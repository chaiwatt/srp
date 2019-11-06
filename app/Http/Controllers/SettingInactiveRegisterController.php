<?php

namespace App\Http\Controllers;

use App\Model\Register;
use Illuminate\Http\Request;

class SettingInactiveRegisterController extends Controller
{
    public function Index(){
        $registers = Register::where('register_status',0)->get();
        return view('setting.inactive.index')->withRegisters($registers);
    }
    public function Delete($id){
        $register = Register::where('register_id',$id)->first();
        if(!Empty($register)){
            $register->delete();
            return redirect()->back()->withSuccess("ลบรายการเรียบร้อยแล้ว");
        }else{
            return redirect()->back()->withError("ไม่สามารถลบรายการ");
        }
    }
}
