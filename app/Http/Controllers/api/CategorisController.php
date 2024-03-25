<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategorisController extends Controller
{
    use GeneralTrait;
    public function index(){
        $Categories = Categorie::where('locale',app()->getLocale())->select('id','name')->get();
        return $this->returnDate('Categories',$Categories);
    }
    public function getcategorybyId(Request $request){
        $category = Categorie::find($request->id);
        if(!$category){
           return $this->returnError(0,'هذا القسم غير موجود');
        }
        return $this->returnDate('category',$category);
    }
    public function changeystatus(Request $request){
        $category = Categorie::find($request->id);
        $category->status = $request->active;
        if($category->save()){
           return  $this->returnSuccess('تم تعديل الحالة بنجاح');
        }

    }

}
