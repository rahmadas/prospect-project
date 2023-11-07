<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\RegisterResource\RegisterResource;
use App\Http\Resources\User\UserResource;
use App\Models\Referral;
use App\Models\User;
use App\Models\User_pro_feature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $inviter = User::where('referral_code', $request['inviter_referral_code'])->first();

        if (!$inviter == null) {
            return response()->json([
                'message' => 'respone referral code not found'
            ]);
        }

        // Di sini, kata sandi (password) yang ada dalam data pendaftaran dienkripsi menggunakan bcrypt, 
        $data['password'] = bcrypt(($data['password']));
        // dan status pengguna diatur menjadi 1 (ini mungkin mengindikasikan status aktif). 
        $data['status'] = 1;
        // Selanjutnya, kode referral baru yang berisi 6 karakter acak (huruf dan angka) dibuat menggunakan Str::random(6).
        $data['referral_code'] = Str::random(6);
        $data['pro_feature_id'] = 1;
        // $data['foto_profile'] = null;
        $responseData = $data;

        // Pengguna baru kemudian dibuat di dalam basis data dengan menggunakan data yang telah disiapkan. 
        // Hasilnya disimpan dalam variabel $user.
        $user = User::create($data);

        // Jika pengguna yang merujuk ditemukan, maka ID pengguna yang merujuk ($inviterId) diambil.  
        if ($inviter) {

            // Kemudian, pencatatan di tabel referral dibuat dengan ID pengguna yang baru dibuat ($user->id), 
            $inviterId = $inviter->id;

            // ID pengguna yang merujuk ($inviterId), dan tanggal saat ini.
            Referral::create([
                'user_id' => $user->id,
                'invited_id' => $inviterId,
                'date' => Carbon::now()
            ]);
        }

        // tabel baru lahir dari tabel user dan pro_feature
        $userProFeature = User_pro_feature::create([
            'pro_feature_id' => $data['pro_feature_id'],
            'user_id' => $user->id
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $responseData['access_token'] = $token;

        return (new RegisterResource($user))->additional([
            'message' => 'Register Success',
            'status' => true,
            'data' => $responseData
        ]);
    }
}
