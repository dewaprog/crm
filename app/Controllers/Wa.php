<?php

namespace App\Controllers;
//require_once('vendor/autoload.php');

class Wa extends BaseController
{
    
    
    // const API ="13cfb0f92e74ec672e3e8031e38d99ad";
    // protected  $api = "13cfb0f92e74ec672e3e8031e38d99ad";
    protected  $api = "dc9a8136a165e9775986f78a3af2600d";
    // protected  $today = ;

    public function rekursive_call(int $page){
    d($page);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://gate.whapi.cloud/messages/list?count=500&offset=&token=wmCHUPitPaSoWxQTzkUDt3LdZY3amD0p', [
          'headers' => [
            'accept' => 'application/json',
          ],
        ]);
        $data=$response->getBody();
        $data=json_decode($data);
        $ctr=0;
        foreach($data->messages as $i => $d){
            $day=($d->timestamp);
            $today=strtotime($date_today); 
            d($day);
            d($today);
            //dd();          
            if($day<$today){break; $ctr=1;}
            $d=(array) $d;
            $q[$i]= $d;
        }
        d("Ctr :".$ctr);
        if($ctr==0)d("data tidak di muat semua");
        else d("data hari ini telah di muat");
        if($ctr==0 && $page <5){
         $page=$page+1;
            $q=array_merge($q, $this->rekursive_call($page)); 
            // dd($page);
        }
        return $q;
    }

    public function index()
    {

    $q = $this->rekursive_call(0);
        
           dd($q);
        $result = array_group_by($q,['chat_id'],true);

        d($result);
        $timeGap=array();
        $noReplay=0;
        foreach($result as $key => $r1){
            if(strpos($key,"whatsapp.net")){
                $timeIncoming=0;
                $timeReplay=0;
                $flag=-1;// 1=replay, 0=new chat
                $temp=-1; 

                foreach($r1 as $i => $arr){
                    
                    
                    if($arr['from_me']==true){
                        $flag=1;
                    }else
                    {
                        $flag=0;
                    }

                    if(($flag==0 ))$timeIncoming=$arr['timestamp'];
                    if(($flag==1 ))$timeReplay=$arr['timestamp'];

                    if($flag==0){
                        if( $temp==1){
                            $timeGap[$key][]=array(
                                'firstChatIn' => $timeIncoming,
                                'firstReplay' => $timeReplay,
                                'gap' => $timeReplay - $timeIncoming,
                                'gapMinute' => round(abs($timeReplay - $timeIncoming) / 60,2). " minute",
                                'status' => 1
                            );
                            $timeIncoming=0;
                            $timeReplay=0;
                        }
                        else if($temp==-1){
                           
                            $noReplay++;    
                            $timeGap[$key][]=array(
                                'firstChatIn' => $timeIncoming,
                                'firstReplay' => $timeReplay,
                                'gap' => $timeReplay - $timeIncoming,
                                'gapMinute' => round(abs($timeReplay - $timeIncoming) / 60,2). " minute",
                                'status' => 0
                            );                       
                        }
                    }


                  
                    // if(($temp==1 && $flag==0 )||($temp== -1 && $flag==0))$timeIncoming=$arr['timestamp'];
                    // if(($flag==1 && $temp==1 )||($temp== -1 && $flag==1))$timeReplay=$arr['timestamp'];
                  
                     $temp=$flag;
                    
                }
            }
        }
        dd($timeGap);
    }
    function newWA(){
    
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:3000/api/getChats',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => "apiKey=".$this->api,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);
     
        curl_close($curl);


        $response=json_decode($response);
        $time=0;

        foreach($response->results as $i => $data){
     

            if(isset($data->conversationTimestamp) && strpos($data->id,"whatsapp.net") ){
                if(isset($data->conversationTimestamp->low))$time=$data->conversationTimestamp->low;
                else $time=$data->conversationTimestamp;

                if($time > strtotime(DATE_TODAY))
                {
                    $q[]=array(
                        'time'=>$time,
                        'jam'=>date("Y-m-d H:i:s",$time),
                        'id'=>$data->id
                    );                
                }
                    
            }
        }
        array_sort_by_multiple_keys($q, ['time'=>SORT_DESC]);
        // dd($q);

        $ctrNoReplay=0;
        $ctr=0;
        $ctrTime=0;
        $a=array();
        foreach($q as $rr){

            $result =new \stdClass(); 
            $d=$this->getMessage(str_replace("@s.whatsapp.net","",$rr['id']));
            $d=json_decode($d);
            $result->chatId=str_replace("@s.whatsapp.net","",$rr['id']);
            $result->date=DATE_TODAY;
            $result->data = $d;
            $a[]=$result;
        }
        d($a);


        echo "<table border='1'>
            <thead>
            <tr>
                <td>ChatID</td>
                <td>date</td>
                <td>Received</td>
                <td>Replay</td>
                <td>Gap</td>
                <td>Balas</td>
            </tr>
            </thead>
        ";
       $abc=0;
       $efg=0;
        foreach ($a as $p){
            echo "<tr>
                    <td>$p->chatId</td>
                    <td colspan='5'>$p->date</td>
        
                  </tr>
                  ;
            ";
            $t_NR=0;
            $t_TM=0;
            $t_ctr=0;
            foreach($p->data as $z){
              if($z->status==1){
                $ctrTime=$ctrTime+$z->gapMinute;
                $t_TM=$t_TM+$z->gapMinute;
                $ctr++;
                $t_ctr++;
              }else{
                $ctrNoReplay++;
                $t_NR++;
              }
              $gap=0;
              if(isset($z->gapMinute))$gap=$z->gapMinute;
              echo "<tr>";
                echo "<td colspan='2'></td>";
                echo "<td>$z->received</td>";
                echo "<td>$z->replay</td>";
                echo "<td>".$gap."</td>";
                echo "<td>$z->status</td>";
              echo "</tr>";
            }
if($t_ctr!=0)$tg=($t_TM / $t_ctr);
else$tg=$t_TM;
            echo"</tr>
                <tr bgcolor='#0f0'>
                    <td colspan='4'>TOTAL</td>

                    <td>".$tg."</td>
                    <td>$t_NR</td>
                </tr>
    ";
        $abc=$abc+$tg;
        $efg=$efg+$t_ctr;
        }
        // echo (" T time : ". $abc."<br/>");
        // echo (" T ctr : ". $efg."<br/>");
        echo (" time : ". $ctrTime."<br/>");
        echo (" ctr : ". $ctr."<br/>");
        // echo (" WAKTU : ". $ctrTime/$ctr."<br/>");
        echo (" TIDAK BALAS : ". $ctrNoReplay."<br/>");
    }

    function getMessage($id){
       
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://localhost:3000/api/fetchMessageById',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => "apiKey=".$this->api."&phone=$id&limit=5000",
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $response=json_decode($response);
        //  dd($response);
            $arr=array();
        foreach($response->results as $data){
            // echo $data->timestamp. " " .date("Y-m-d H:i:s",$data->timestamp)."<br/>";
            if(($data->key->remoteJid==$id."@s.whatsapp.net" )&& $data->timestamp > strtotime(DATE_TODAY))
            {
                // if(isset($data->from_me))$fromMe=$data->fromMe;
                // else $from_me='';

                if(isset($data->body)){
                    $arr[]=array(
                        'msg'=>$data->body,
                        'time'=>$data->timestamp,
                        'type'=>$data->type,
                        'fromMe'=>$data->fromMe,
                        // 'status'=>$data->status,
                    );
                    //  d($data);
                }
              else    {
                $arr[]=array(
                    'msg'=>'',
                    'time'=>$data->timestamp,
                    'type'=>$data->type,
                    'fromMe'=>$data->fromMe,
                    // 'status'=>$status,
                );
                
              }
            }
        
        }
       
        if(isset($arr))array_sort_by_multiple_keys($arr, ['time'=>SORT_DESC]);
  
        // d($arr);

        $noReplay=0;
        $ctrnoReplay=0;
        $timeReceived=0;
        $timeReplay=0;
        $conv=array();

        $flag=0;
        $tempTime=0;
        $temp=0;
        $j=0;
        $ctr=0;
        if(isset($arr))
        foreach($arr as $i => $r){

            //saat pertama x tidak dibalas
            if($i==0)
                if($r['fromMe']==false){
                    $ctrnoReplay++;
                    $conv[]=array(
                        'received'=>0,
                        'replay'=>0,
                        'gap'=>0,
                        'status'=>0
                    );
                    $flag=$i;
                    $noReplay=1;
                    $ctr++;
                }

            //cek kondisi tidak di balas dapatkan waktu
            if(($r['fromMe']==true && $noReplay==1 )){

                // if(($r['fromMe']==false && $i == sizeof($arr)-1)){
                //     $conv[$ctr-1]=array(
                //         // 'chatId'=>$id,
                //         // 'date'=>DATE_TODAY,
                //         'received'=>$tempTime,
                //         'replay'=>0,
                //         'gap'=>$tempTime*-1,
                //         'gapMinute' => 0,
                //         'status'=>1
                //     );
                // }else
                {
                    $conv[$ctr-1]=array(
                        // 'chatId'=>$id,
                        // 'date'=>DATE_TODAY,
                        'received'=>$tempTime,
                        'replay'=>0,
                        'gap'=>$tempTime*-1,
                        'gapMinute' => 0,
                        'status'=>0
                    );
                }
            }
    

            if($r['fromMe']==true)$timeReplay=$r['time'];
            else $timeReceived=$r['time'];

            //update received dari paling atas
            if($r['fromMe']==false && $temp===false){
                // $conv[$ctr]['received']=$timeReceived;
                $conv[$ctr-1]=array_replace($conv[$ctr-1],array('received'=>$timeReceived,'gap'=>$conv[$ctr-1]['replay'] - $timeReceived,'gapMinute'=> round(abs($conv[$ctr-1]['replay']- $timeReceived) / 60,2)));
      
            }

            if($r['fromMe']==false && $temp==true){
                $gapTime=$timeReplay-$timeReceived;
            
                $conv[]=array(
                    // 'chatId'=>$id,
                    // 'date'=>DATE_TODAY,
                    'received'=>$timeReceived,
                    'replay'=>$timeReplay,
                    'gap'=>$timeReplay - $timeReceived,
                    'gapMinute' => round(abs($timeReplay - $timeReceived) / 60,2),
                    'status'=>1
                );
                $ctr++;
                
                $noReplay=0;
                $timeReplay=0;
                $timeReceived=0;
            }
            $temp=$r['fromMe'];
            $tempTime=$r['time'];
        }
        // dd($conv);
        $conv=json_encode($conv);
        return $conv;
    }
}
