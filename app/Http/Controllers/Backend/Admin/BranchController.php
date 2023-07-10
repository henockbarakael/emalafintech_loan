<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DateController;
use App\Http\Controllers\GenerateIdController;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BranchController extends Controller
{
    public function index(){
        $branches = Branch::all();
        return view('backend.branche.all', compact('branches'));
    }

    public function add(Request $request){

        $request->validate([
            'btownship'   => 'required|string|max:255',
            'bcity'   => 'required|string|max:255',
            'bname'   => 'required|string|max:255',
            'email'   => 'required|string|max:255',
        ]);

        $btownship = $request->btownship;
        $bcity = $request->bcity;
        $bname = $request->bname;
       
        $bemail = $request->email;

        $date = new DateController;
        $today = $date->todayDate();
        $code_agence = new GenerateIdController;
        $bcode = $code_agence->password();
        Branch::create([
            'bcode'   => $bcode,
            'bname'   => $bname,
            'bemail'   => $bemail,
            'btownship'   => $btownship,
            'bcity'   => $bcity,
            'created_at'   => $today,
            'updated_at'   => $today,
        ]);

        Alert::success('Succès', 'Agence créée avec succès!');
        return redirect()->route('admin.branch.all');
    }

    public function edit(Request $request){
        $request->validate([
            'btownship'   => 'required|string|max:255',
            'bcity'   => 'required|string|max:255',
            'bname'   => 'required|string|max:255',
            'bemail'   => 'required|string|max:255',
        ]);

        $btownship = $request->btownship;
        $bcity = $request->bcity;
        $bname = $request->bname;
        $branche_id = $request->id;
        $bemail = $request->bemail;

        $date = new DateController;
        $today = $date->todayDate();

        DB::beginTransaction();
        try {
            DB::table('branches')->where('id',$branche_id)->update([
                'bname' => $bname,
                'bcity' => $bcity,
                'btownship' => $btownship,
                'bemail' => $bemail,
                'updated_at'   => $today,
            ]);
            DB::commit();
            Alert::success('Succès', 'Agence supprimée avec succès !');
            return redirect()->route('admin.branch.all');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Erreur', 'Une erreur est survenue lors de la suppression de l\'agence!');
            return redirect()->back();
        }

    }

    public function delete(Request $request){
        $branche_id = $request->id;
        DB::beginTransaction();
        try {
            DB::table('branches')->delete($branche_id);
            DB::commit();
            Alert::success('Succès', 'Agence supprimée avec succès !');
            return redirect()->route('admin.branch.all');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Erreur', 'Une erreur est survenue lors de la suppression de l\'agence!');
            return redirect()->back();
        }
        
    }

    public function recharge(){
        $branches = Branch::all();
        return view('backend.branche.all', compact('branches'));
    }
}
