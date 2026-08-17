<?php

namespace App\Http\Controllers\Shop;

use App\Models\City;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('profile.index')->with('success', 'اطلاعات کاربری با موفقیت ویرایش شد');
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses;
        return view('profile.addresses.index', compact('addresses'));
    }
    public function address_create()
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.addresses.create', compact('provinces', 'cities'));
    }
    public function address_store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string'
        ]);

        UserAddress::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->route('profile.addresses')->with('success', 'آدرس شما با موفقیت ثبت شد');
    }
    public function address_edit(UserAddress $address)
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.addresses.edit', compact('address', 'provinces', 'cities'));
    }
    public function address_update(Request $request, UserAddress $address)
    {
        $request->validate([
            'title' => 'required|string',
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string'
        ]);

        $address->update([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->route('profile.addresses')->with('success', 'آدرس شما با موفقیت ویرایش شد');
    }

    public function wishlist_add_to(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);

        if (!Auth::check()) {
            return redirect()->back()->with('warning', 'برای افزودن محصول به لیست علاقه مندی، باید وارد سیستم شوید');
        }

        Wishlist::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id
        ]);
        return redirect()->back()->with('success', ' محصول موردنظر با موفقیت به علاقه مندی ها افزوده شد');
    }

    public function wishlist()
    {
        $wishlist = Auth::user()->wishlist;
        return view('profile.wishlist', compact('wishlist'));
    }

    public function remove_from_wishlist(Request $request)
    {
        $request->validate([
            'wishlist' => 'required|integer|exists:wishlist,id'
        ]);

        $wishlist = Wishlist::findOrFail($request->wishlist);
        $wishlist->delete();
        return redirect()->back()->with('warning', ' محصول موردنظر با موفقیت از لیست علاقه مندی ها حذف شد');
    }
}
