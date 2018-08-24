<?php
namespace Pokeface\MemeServer\Http\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;



class SaveMemes implements ShouldQueue
{
	/**
     * @var
     */
    protected $memes;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($memes)
    {
        $this->memes = $memes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(count($this->memes)){
            $disk = config('disk','local');
            foreach($this->memes as $meme){
                $path_md5=md5($meme['url']);
                $meme = Meme::where('path_md5',$path_md5)->first();
                if(empty($meme)){
                    $pic_data=Curl::to($meme['url'])
                        ->returnResponseObject()
                        ->get();
                    if($pic_data->status==200){
                        $pic_md5=md5($pic_data->content);
                        $meme = Meme::where('md5',$pic_md5)->first();
                        if(empty($meme)){
                            Storage::disk($disk)->put('memes/'.generate_invitation_code().'.txt', 'Contents');

                        }
                    }
                }
            }
        }
    }


    public function generate_invitation_code(){
            $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $rand = $code[rand(0, 25)]
                . strtoupper(dechex(date('m')))
                . date('d') . substr(time(), -5)
                . substr(microtime(), 2, 5)
                . sprintf('%02d', rand(0, 99));
            for (
                $a = md5($rand, true),
                $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
                $d = '',
                $f = 0;
                $f < 8;
                $g = ord($a[$f]),
                $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F],
                $f++
            ) ;

            return $d;
    }



}