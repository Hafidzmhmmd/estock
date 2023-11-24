<?php

namespace App\Http\Controllers;

use App\Http\Helpers\AccessHelpers;
use App\User;
use App\RoleMenu;
use App\MenuAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {

            $id = $request->id;
            $nama = $request->nama;
            $username = $request->username;
            $password = $request->password;
            $role = $request->role;
            $bidang = $request->bidang;

            if ($id) {
                $usr = User::where('id', $id)->first();
            } else {
                $usr = new User();
                $usr->password = '123456';
            }

            $usr->name = $nama;
            $usr->username = $username;
            $usr->password = Hash::make($password);
            $usr->role = $role;
            $usr->bidang = $bidang;

            if($usr->save()) {
                $message = 'User Berhasil Disimpan';

                $menuAccess = RoleMenu::where('role', $usr->role)->get();
                foreach($menuAccess as $ma){
                    $menuAcc = new MenuAccess;
                    $menuAcc->menuid = $ma->menuid;
                    $menuAcc->userid = $usr->id;
                    $menuAcc->save();
                }

                $status = true;
            } else {
                $message = 'Gagal Menyimpan User';
                $status = false;
            }

            $result = [
                'status' => $status,
                'message' => $message
            ];
            return response()->json($result, 200);

        } else {
            return response()->json([
                'status' => $status,
                'message' => 'Anda tidak memiliki akses'
            ]);
        }
    }

    public function detail($id)
    {
        if (AccessHelpers::isAdmin()) {
            if ($id) {
                $data = User::where('id', $id)->first();
                if ($data) {
                    return response()->json([
                        'status' => 'success',
                        'msg' => 'berhasil mendapatkan data',
                        'data' => $data
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'msg' => 'data tidak ditemukan'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'bad request'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }
    }


    public function delete($id){
        if(AccessHelpers::isAdmin()) {
            if ($id) {
                $data = User::where('id', $id)->delete();

                if ($data) {
                    $message = 'User Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ];
                } else {
                    $message = 'Gagal Menghapus User';
                    $status = false;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ];

                }
                return response()->json($result,200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'bad request'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }
    }

}
