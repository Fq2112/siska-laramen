<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\Carousel;
use App\Cities;
use App\Nations;
use App\PaymentCategory;
use App\PaymentMethod;
use App\Plan;
use App\Provinces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebContentsController extends Controller
{
    public function showCarouselsTable()
    {
        $carousels = Carousel::all();

        return view('_admins.tables.webContents.carousel-table', compact('carousels'));
    }

    public function createCarousels(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1024',
            'title' => 'required|string|max:191',
            'captions' => 'required|string|max:191',
        ]);

        $name = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images/carousel'), $name);

        Carousel::create([
            'image' => $name,
            'title' => $request->title,
            'captions' => $request->captions,
        ]);

        return back()->with('success', 'Carousel (' . $request->title . ') is successfully created!');
    }

    public function updateCarousels(Request $request)
    {
        $carousel = Carousel::find($request->id);

        $this->validate($request, [
            'image' => 'image|mimes:jpg,jpeg,gif,png|max:1024',
            'title' => 'required|string|max:191',
            'captions' => 'required|string|max:191',
        ]);

        if ($request->hasfile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            if ($carousel->image != '') {
                unlink(public_path('images/carousel/' . $carousel->image));
            }
            $request->file('image')->move(public_path('images/carousel'), $name);

        } else {
            $name = $carousel->image;
        }

        $carousel->update([
            'image' => $name,
            'title' => $request->title,
            'captions' => $request->captions,
        ]);

        return back()->with('success', 'Carousel (' . $carousel->title . ') is successfully updated!');
    }

    public function deleteCarousels($id)
    {
        $carousel = Carousel::find(decrypt($id));
        if ($carousel->image != '') {
            unlink(public_path('images/carousel/' . $carousel->image));
        }
        $carousel->delete();

        return back()->with('success', 'Carousel (' . $carousel->title . ') is successfully deleted!');
    }

    public function showPaymentCategoriesTable()
    {
        $categories = PaymentCategory::all();

        return view('_admins.tables.webContents.paymentCategory-table', compact('categories'));
    }

    public function createPaymentCategories(Request $request)
    {
        PaymentCategory::create([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updatePaymentCategories(Request $request)
    {
        $category = PaymentCategory::find($request->id);
        $category->update([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', '' . $category->name . ' is successfully updated!');
    }

    public function deletePaymentCategories($id)
    {
        $category = PaymentCategory::find(decrypt($id));
        $category->delete();

        return back()->with('success', '' . $category->name . ' is successfully deleted!');
    }

    public function showPaymentMethodsTable()
    {
        $methods = PaymentMethod::all();

        return view('_admins.tables.webContents.paymentMethod-table', compact('methods'));
    }

    public function createPaymentMethods(Request $request)
    {
        $this->validate($request, [
            'logo' => 'required|image|mimes:jpg,jpeg,gif,png|max:1024',
        ]);

        $name = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move(public_path('images/paymentMethod'), $name);

        PaymentMethod::create([
            'logo' => $name,
            'name' => $request->name,
            'payment_category_id' => $request->category_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updatePaymentMethods(Request $request)
    {
        $method = PaymentMethod::find($request->id);

        $this->validate($request, [
            'logo' => 'image|mimes:jpg,jpeg,gif,png|max:1024',
        ]);

        if ($request->hasfile('logo')) {
            $name = $request->file('logo')->getClientOriginalName();
            if ($method->logo != '') {
                unlink(public_path('images/paymentMethod/' . $method->logo));
            }
            $request->file('logo')->move(public_path('images/paymentMethod'), $name);

        } else {
            $name = $method->logo;
        }

        $method->update([
            'logo' => $name,
            'name' => $request->name,
            'payment_category_id' => $request->category_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', '' . $method->name . ' is successfully updated!');
    }

    public function deletePaymentMethods($id)
    {
        $method = PaymentMethod::find(decrypt($id));
        if ($method->logo != '') {
            unlink(public_path('images/paymentMethod/' . $method->logo));
        }
        $method->delete();

        return back()->with('success', '' . $method->name . ' is successfully deleted!');
    }

    public function showPlansTable()
    {
        $plans = Plan::all();

        return view('_admins.tables.webContents.plan-table', compact('plans'));
    }

    public function createPlans(Request $request)
    {
        $checkIsBest = Plan::where('isBest', true)->count();
        if ($checkIsBest > 0 && $request->isBest == true) {
            foreach (Plan::where('isBest', true)->get() as $row) {
                $row->update([
                    'caption' => 'Job Posting ' . $row->name . ' Package',
                    'isBest' => false
                ]);
            }
        }

        Plan::create([
            'name' => $request->name,
            'caption' => $request->caption,
            'price' => $request->price,
            'discount' => $request->discount,
            'job_ads' => $request->job_ads,
            'isQuiz' => $request->isQuiz == 1 ? true : false,
            'quiz_applicant' => $request->quiz_applicant == null ? 0 : $request->quiz_applicant,
            'price_quiz_applicant' => $request->price_quiz_applicant == null ? 0 : $request->price_quiz_applicant,
            'isPsychoTest' => $request->isPsychoTest == 1 ? true : false,
            'psychoTest_applicant' => $request->psychoTest_applicant == null ? 0 : $request->psychoTest_applicant,
            'price_psychoTest_applicant' => $request->price_psychoTest_applicant == null ? 0 :
                $request->price_psychoTest_applicant,
            'benefit' => preg_replace('/\s+/', ' ', trim($request->benefit)),
            'isBest' => $request->isBest,
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updatePlans(Request $request)
    {
        $checkIsBest = Plan::where('isBest', true)->count();
        if ($checkIsBest > 0 && $request->isBest == true) {
            foreach (Plan::where('isBest', true)->get() as $row) {
                $row->update([
                    'caption' => 'Job Posting ' . $row->name . ' Package',
                    'isBest' => false
                ]);
            }
        }

        $plan = Plan::find($request->id);
        $plan->update([
            'name' => $request->name,
            'caption' => $request->caption,
            'price' => $request->price,
            'discount' => $request->discount,
            'job_ads' => $request->job_ads,
            'isQuiz' => $request->isQuiz == 1 ? true : false,
            'quiz_applicant' => $request->quiz_applicant == null ? 0 : $request->quiz_applicant,
            'price_quiz_applicant' => $request->price_quiz_applicant == null ? 0 : $request->price_quiz_applicant,
            'isPsychoTest' => $request->isPsychoTest == 1 ? true : false,
            'psychoTest_applicant' => $request->psychoTest_applicant == null ? 0 : $request->psychoTest_applicant,
            'price_psychoTest_applicant' => $request->price_psychoTest_applicant == null ? 0 :
                $request->price_psychoTest_applicant,
            'benefit' => preg_replace('/\s+/', ' ', trim($request->benefit)),
            'isBest' => $request->isBest,
        ]);

        return back()->with('success', '' . $plan->name . ' is successfully updated!');
    }

    public function deletePlans($id)
    {
        $plan = Plan::find(decrypt($id));
        $plan->delete();

        return back()->with('success', '' . $plan->name . ' is successfully deleted!');
    }

    public function showNationsTable()
    {
        $nations = Nations::all();

        return view('_admins.tables.webContents.nation-table', compact('nations'));
    }

    public function createNations(Request $request)
    {
        Nations::create(['name' => $request->name]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateNations(Request $request)
    {
        $nation = Nations::find($request->id);
        $nation->update(['name' => $request->name]);

        return back()->with('success', '' . $nation->name . ' is successfully updated!');
    }

    public function deleteNations($id)
    {
        $nation = Nations::find(decrypt($id));
        $nation->delete();

        return back()->with('success', '' . $nation->name . ' is successfully deleted!');
    }

    public function showProvincesTable()
    {
        $provinces = Provinces::all();

        return view('_admins.tables.webContents.province-table', compact('provinces'));
    }

    public function createProvinces(Request $request)
    {
        Provinces::create(['name' => $request->name]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateProvinces(Request $request)
    {
        $province = Provinces::find($request->id);
        $province->update(['name' => $request->name]);

        return back()->with('success', '' . $province->name . ' is successfully updated!');
    }

    public function deleteProvinces($id)
    {
        $province = Provinces::find(decrypt($id));
        $province->delete();

        return back()->with('success', '' . $province->name . ' is successfully deleted!');
    }

    public function showCitiesTable()
    {
        $cities = Cities::all();

        return view('_admins.tables.webContents.city-table', compact('cities'));
    }

    public function createCities(Request $request)
    {
        Cities::create([
            'province_id' => $request->province_id,
            'name' => $request->name
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateCities(Request $request)
    {
        $city = Cities::find($request->id);
        $city->update([
            'province_id' => $request->province_id,
            'name' => $request->name
        ]);

        return back()->with('success', '' . $city->name . ' is successfully updated!');
    }

    public function deleteCities($id)
    {
        $city = Cities::find(decrypt($id));
        $city->delete();

        return back()->with('success', '' . $city->name . ' is successfully deleted!');
    }
}
