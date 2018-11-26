<?php

namespace App\Http\Controllers\Admins;

use App\Accepting;
use App\Admin;
use App\Agencies;
use App\Blog;
use App\ConfirmAgency;
use App\Feedback;
use App\Http\Controllers\Controller;
use App\QuizInfo;
use App\QuizType;
use App\Seekers;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $newSeeker = Seekers::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newApp = Accepting::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $newAgency = Agencies::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();
        $newJobPost = ConfirmAgency::where('created_at', '>=', today()->subDays('3')->toDateTimeString())->count();

        $users = User::all();
        $agencies = Agencies::all();
        $seekers = Seekers::all();

        $blogs = Blog::all();

        return view('_admins.home-admin', compact('newSeeker', 'newApp', 'newAgency', 'newJobPost',
            'users', 'agencies', 'seekers', 'blogs'));
    }

    public function showInbox()
    {
        $contacts = Feedback::orderByDesc('id')->get();

        return view('_admins.inbox', compact('contacts'));
    }

    public function composeInbox(Request $request)
    {
        $this->validate($request, [
            'inbox_to' => 'required|string|email|max:255',
            'inbox_subject' => 'string|min:3',
            'inbox_message' => 'required'
        ]);
        $data = array(
            'email' => $request->inbox_to,
            'subject' => $request->inbox_subject,
            'bodymessage' => $request->inbox_message
        );
        Mail::send('emails.admins.admin-mail', $data, function ($message) use ($data) {
            $message->from(env('MAIL_USERNAME'));
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        return back()->with('success', 'Successfully send a message to ' . $data['email'] . '!');
    }

    public function deleteInbox(Request $request)
    {
        $contact = Feedback::find(decrypt($request->id));
        $contact->delete();

        return back()->with('success', 'Feedback from ' . $contact->name . ' <' . $contact->email . '> is successfully deleted!');
    }

    public function updateProfile(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $this->validate($request, [
            'myAva' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);
        if ($request->hasFile('myAva')) {
            $name = $request->file('myAva')->getClientOriginalName();
            if ($admin->ava != '' || $admin->ava != 'avatar.png') {
                Storage::delete('public/admins/' . $admin->ava);
            }
            $request->file('myAva')->storeAs('public/admins', $name);

        } else {
            $name = $admin->ava;
        }
        $admin->update([
            'ava' => $name,
            'name' => $request->myName
        ]);

        return back()->with('success', 'Successfully update your profile!');
    }

    public function updateAccount(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->user()->id);

        if (!Hash::check($request->myPassword, $admin->password)) {
            return back()->with('error', 'Your current password is incorrect!');

        } else {
            if ($request->myNew_password != $request->myPassword_confirmation) {
                return back()->with('error', 'Your password confirmation doesn\'t match!');

            } else {
                $admin->update([
                    'email' => $request->myEmail,
                    'password' => bcrypt($request->myPassword)
                ]);
                return back()->with('success', 'Successfully update your account!');
            }
        }
    }

    public function showQuizInfo(Request $request)
    {
        $infos = QuizInfo::orderByDesc('id')->get();
        $types = QuizType::all();
        $vacancies = Vacancies::where('isPost', true)->whereHas('getPlan', function ($query) {
            $query->where('isQuiz', true);
        })->get();

        if ($request->has("vac_ids")) {
            $findVac = Vacancies::whereIn('id', explode(',', $request->vac_ids))->get()->pluck('id');
        } else {
            $findVac = null;
        }

        return view('_admins.quiz-setup', compact('infos', 'types', 'vacancies', 'findVac'));
    }

    public function getQuizVacancyInfo($id)
    {
        return Vacancies::whereIn('id', explode(',', $id))->get();
    }

    public function createQuizInfo(Request $request)
    {
        $it = new \MultipleIterator();
        $it->attachIterator(new \ArrayIterator($request->vacancy_ids));
        $it->attachIterator(new \ArrayIterator($request->unique_code));
        $it->attachIterator(new \ArrayIterator($request->total_question));
        $it->attachIterator(new \ArrayIterator($request->time_limit));
        $it->attachIterator(new \ArrayIterator($request->question_ids));
        foreach ($it as $value) {
            QuizInfo::create([
                'vacancy_id' => $value[0],
                'unique_code' => $value[1],
                'total_question' => $value[2],
                'time_limit' => $value[3],
                'question_ids' => $value[4]
            ]);
        }
        $total = count($request->vacancy_ids);
        $str = $total > 1 ? 'quiz are' : 'quiz is';

        return redirect()->route('quiz.info')->with('success', '' . $total . ' ' . $str . ' successfully created!');
    }

    public function updateQuizInfo(Request $request)
    {
        $info = QuizInfo::find($request->id);
        $info->update([
            'vacancy_id' => $request->vacancy_id,
            'total_question' => $request->total_question,
            'question_ids' => $request->question_ids,
            'unique_code' => $request->unique_code,
            'time_limit' => $request->time_limit
        ]);

        return redirect()->route('quiz.info')
            ->with('success', 'Quiz #' . $info->unique_code . ' is successfully updated!');
    }

    public function deleteQuizInfo(Request $request)
    {
        $info = QuizInfo::find(decrypt($request->id));
        $info->delete();

        return redirect()->route('quiz.info')->with('success', 'Quiz #' . $info->unique_code . ' is successfully deleted!');
    }
}
