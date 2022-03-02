
<?php
public function LoginOTPVerify(Request $request)
    {
        $otp_arr = OTP::where('otp_token', $request->otp_token)->where('otp', $request->otp)->latest()->first();
        if ($otp_arr == null) {
            $data = array(
                'login_token' => 'NO Match',
                'status' => 0
            );
        } else {
            OTP::where('otp_token', $request->otp_token)
                ->where('otp', $request->otp)
                ->update(['ip_verify' => 1]);
            Auth::loginUsingId($otp_arr->user_id, true);

            //save login session start
            $model = User::where('id', $otp_arr->user_id)->first();
            $userip = trim($_SERVER['REMOTE_ADDR']);
           // $userip="192.168.1.147";

            Cache::add('IP_Val', $userip, now()->addMinutes(20));

            $sessID = $model->id . "ID-" . date('Ymdhis') . uniqid();
            $affected = DB::table('users')
                ->where('id', $model->id)
                ->update(['user_session_id' => $sessID, 'last_activetime' => date('Y-m-d H:i:s')]);

            DB::table('login_activity')->insert(
                [
                    'user_id' => $model->id,
                    'user_name' => $model->name,
                    'login_start' => date('Y-m-d H:i:s'),
                    'logout_start' => date('Y-m-d H:i:s'),
                    'login_details' => 'OTP Disable login',
                    'session_id' => $sessID,
                    'created_on' => date('Ymd'),
                ]
            );
            //save login session stop


            $data = array(
                'login_token' => '',
                'status' => 1
            );
        }

        return response()->json($data);
    }

      public function customLogin(Request $request)
    {
        $phone = $request->txtPhone;
        $myMacAddress = AyraHelp::getMyMACAddress();
        $myIP = $_SERVER['REMOTE_ADDR'];
        //$myIP="192.168.1.147";

        $whitelistData = array(
            '127.0.0.1',
            '192.168.1.180',
            '::1'
        );
        //if my system is ERP then can able to login with otp **
        if (in_array($myIP, $whitelistData)) {

            $model = User::where('phone', $phone)->first();
            if ($model != null) {

                $userID=$model->id;
                $otp_arr_data=OTP::where('user_id',$userID)->where('mac_address',$myMacAddress)->where('ip_verify',1)->whereDate('expiry', Carbon::today())->latest()->first();
                if($otp_arr_data!=null){
                    Auth::loginUsingId($model->id, true);
                    //save login session start
                    Cache::add('IP_Val',$myIP, now()->addMinutes(20));

                    $sessID=$model->id."ID-".date('Ymdhis').uniqid();
                     $affected = DB::table('users')
                    ->where('id', $model->id)
                    ->update(['user_session_id' => $sessID,'last_activetime'=>date('Y-m-d H:i:s')]);

                      DB::table('login_activity')->insert(
                        [
                          'user_id' =>$model->id,
                          'user_name' =>$model->name,
                          'login_start' => date('Y-m-d H:i:s'),
                          'logout_start' => date('Y-m-d H:i:s'),
                          'login_details' => 'OTP Disable login',
                          'session_id' => $sessID,
                          'created_on' =>date('Ymd'),
                       ]
                      );
                      //save login session stop

                      $data=array(
                      'login_token'=>'',
                      'status'=>2
                      );
                      return response()->json($data);


                }else{
                  //  $otp = AyraHelp::getOTP();
                   $otp =123456;
                    $otp_token = uniqid(base64_encode(str_random(60)));

                    $otpObj = new OTP;
                    $otpObj->user_id = $model->id;
                    $otpObj->otp = $otp;
                    $otpObj->otp_type = 4;
                    $otpObj->user_ip = $myIP;
                    $otpObj->mac_address = $myMacAddress;
                    $otpObj->location_details = 'OFFICE ADDRESS';
                    $otpObj->otp_token = $otp_token;
                    $otpObj->expiry = date('Y-m-d H:i:s');
                    $otpObj->save();
                    $otp_msg = 'FROM Office System';

                    $user_name = $model->name;
                    $phone = $model->phone;
                    $msg = $otp . ' OTP :Name :' . $user_name . ' , Location ' . $otp_msg;
                    //$phone="7703886088";
                   // $this->msg91SendSMS($phone, $msg);
                    //$this->PRPSendSMS($phone,$msg);


                    $data = array(
                        'login_token' => $otp_token,
                        'status' => 1
                    );
                    return response()->json($data);
                }


            }else{
                $data=array(
                    'login_token'=>'User Does not Associated with this number',
                    'status'=>0
                    );
                return response()->json($data);

            }
        }
        //---------------------------------------**
        //if system is not ERP system then login with mac address  or otp
        //if user is login to diffent system then login with otp verified ***
        $model = User::where('phone', $phone)->first();
        if ($model != null) {

            $modelMAC = User::where('phone', $phone)->where('mac_address', $myMacAddress)->first();


            if ($modelMAC != null) { //mac address binded

                $userID=$model->id;
                $otp_arr_data=OTP::where('user_id',$userID)->where('mac_address',$myMacAddress)->where('ip_verify',1)->whereDate('expiry', Carbon::today())->latest()->first();
                if($otp_arr_data!=null){
                    Auth::loginUsingId($model->id, true);
                    //save login session start
                    Cache::add('IP_Val',$myIP, now()->addMinutes(20));

                    $sessID=$model->id."ID-".date('Ymdhis').uniqid();
                     $affected = DB::table('users')
                    ->where('id', $model->id)
                    ->update(['user_session_id' => $sessID,'last_activetime'=>date('Y-m-d H:i:s')]);

                      DB::table('login_activity')->insert(
                        [
                          'user_id' =>$model->id,
                          'user_name' =>$model->name,
                          'login_start' => date('Y-m-d H:i:s'),
                          'logout_start' => date('Y-m-d H:i:s'),
                          'login_details' => 'OTP Disable login',
                          'session_id' => $sessID,
                          'created_on' =>date('Ymd'),
                       ]
                      );
                      //save login session stop

                      $data=array(
                      'login_token'=>'',
                      'status'=>2
                      );
                      return response()->json($data);


                }else{
                // echo "mila"; otp will be 123456
                //$otp = AyraHelp::getOTP();
                $otp = '123456';
                $otp_token = uniqid(base64_encode(str_random(60)));

                $otpObj = new OTP;
                $otpObj->user_id = $model->id;
                $otpObj->otp = $otp;
                $otpObj->otp_type = 5; //login with mac address otp
                $otpObj->user_ip = $myIP;
                $otpObj->mac_address = $myMacAddress;
                $otpObj->location_details = 'OFFICE ADDRESS';
                $otpObj->otp_token = $otp_token;
                $otpObj->expiry = date('Y-m-d H:i:s');
                $otpObj->save();
                $otp_msg = 'FROM Office System';

                // $user_name = $model->name;
                // $phone = $model->phone;
                // $msg = $otp . ' OTP :Name :' . $user_name . ' , Location ' . $otp_msg;
                // //$phone="7703886088";
                // $this->msg91SendSMS($phone, $msg);
                // //$this->PRPSendSMS($phone,$msg);


                $data = array(
                    'login_token' => $otp_token,
                    'status' => 1
                );
                return response()->json($data);

                }






            }else{
                 //mac address not  binded
                 //$myMacAddress=$myMacAddress;
                 $userID=$model->id;
                 $otp_arr_data=OTP::where('user_id',$userID)->where('mac_address',$myMacAddress)->where('user_ip',$myIP)->where('ip_verify',1)->whereDate('expiry', Carbon::today())->latest()->first();
                 if($otp_arr_data!=null){
                     Auth::loginUsingId($model->id, true);
                     //save login session start
                     Cache::add('IP_Val',$myIP, now()->addMinutes(20));

                     $sessID=$model->id."ID-".date('Ymdhis').uniqid();
                      $affected = DB::table('users')
                     ->where('id', $model->id)
                     ->update(['user_session_id' => $sessID,'last_activetime'=>date('Y-m-d H:i:s')]);

                       DB::table('login_activity')->insert(
                         [
                           'user_id' =>$model->id,
                           'user_name' =>$model->name,
                           'login_start' => date('Y-m-d H:i:s'),
                           'logout_start' => date('Y-m-d H:i:s'),
                           'login_details' => 'OTP Disable login',
                           'session_id' => $sessID,
                           'created_on' =>date('Ymd'),
                        ]
                       );
                       //save login session stop

                       $data=array(
                       'login_token'=>'',
                       'status'=>2
                       );
                       return response()->json($data);


                 }else{
               // $otp = AyraHelp::getOTP();
               $otp=123456;
                $otp_token = uniqid(base64_encode(str_random(60)));
                $otpObj = new OTP;
                $otpObj->user_id = $model->id;
                $otpObj->otp = $otp;
                $otpObj->otp_type = 6; //login with mac address otp
                $otpObj->user_ip = $myIP;
                $otpObj->mac_address = $myMacAddress;
                $otpObj->location_details = 'OFFICE ADDRESS';
                $otpObj->otp_token = $otp_token;
                $otpObj->expiry = date('Y-m-d H:i:s');
                $otpObj->save();
                $otp_msg = 'FROM Home System';

                $user_name = $model->name;
                $phone = $model->phone;
                $msg = $otp . ' OTP :Name :' . $user_name . ' , Location ' . $otp_msg;
                //$phone="7703886088";
                //$this->PRPSendSMS($phone, $msg); //as now Disbaled
                //$this->PRPSendSMS($phone,$msg);


                $data = array(
                    'login_token' => $otp_token,
                    'status' => 1
                );
                return response()->json($data);
                 }




            }

        }
        //---------------------------***

    }


  public function handle($request, Closure $next)
    {

        



        $OTPEnableCheck=AyraHelp::OTPEnableStatus();

        if($OTPEnableCheck){
            //if OTP is enable
            $whitelistData = array(
                '127.0.0.1',
                '::1'
            );
            if(!in_array($_SERVER['REMOTE_ADDR'], $whitelistData)){
                // $user_ip = trim($_SERVER['REMOTE_ADDR']);
                // $access_url = "http://api.ipstack.com/";
                // $iptkey=AyraHelp::getIPKEY();
                // $access_key = "?access_key=".$iptkey;
                // $ip_data = json_decode(file_get_contents($access_url . $user_ip . $access_key), true);
                //  $userip=$ip_data['ip'];
                 $ip_val = Cache::get('IP_Val');
                 $userip=$ip_val;
                // $userip="192.168.1.147";

            }else{
                $userip=trim($_SERVER['REMOTE_ADDR']);
                //$userip="192.168.1.147";

            }
            $otp_arr_data=OTP::where('user_ip',$userip)->where('ip_verify',1)->whereDate('expiry', Carbon::today())->first();
            if($otp_arr_data==null){
              if (Auth::user()) {
              $sessID = Auth::user()->user_session_id;
              $affected = DB::table('login_activity')
                        ->where('session_id', $sessID)
                        ->update(['logout_start' => date('Y-m-d H:i:s')]);
              }

                Auth::logout();

            }

        }
        else{
            //if OTP is not eable
        }






        return $next($request);
    }