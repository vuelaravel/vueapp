<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;
use Auth;
class BrandController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //
    public function Allbrand(){
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index',compact('brands'));
    }
    
    public function StoreBrand(Request $request){
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
            ],
           [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_image.min' => 'Brand longer than 4 characters',
           ]
         );
        $brand_image=$request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand';
        $last_image = $up_location.'/'.$img_name;
        $brand_image->move($up_location,$img_name);
        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at'  => Carbon::now()

        ]);
        return Redirect()->back()->with('success','Brand Added Successfully.');
    }
    public function softDelete($id){
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image); 
        $delete = Brand::find($id)->delete();
        return Redirect()->back()->with('success','Brand Trash Successfully.');
 
   }
   public function edit($id){
         $brands = Brand::find($id);
         return view('admin.brand.edit',compact('brands'));

   }
   public function Update(Request $request,$id){
    $validated = $request->validate([
        'brand_name' => 'required|min:4'
        ],
       [
        'brand_name.required' => 'Please Input Brand Name',
        'brand_image.min' => 'Brand longer than 4 characters',
       ]
     );
    $brand_image=$request->file('brand_image');
    if($brand_image){
        $old_image = $request->old_image;
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand';
        $last_image = $up_location.'/'.$img_name;
        $brand_image->move($up_location,$img_name);  
        unlink($old_image);
        $update = Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at'  => Carbon::now()
        ]);
    }else{
        $update = Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'created_at'  => Carbon::now()
        ]);
    }
    
   return Redirect()->back()->with('success','Brand Updated Successfully');
}
public function Logout(){
    Auth::logout();
    return Redirect()->route('login')->with('success','User Logout');
}

}
