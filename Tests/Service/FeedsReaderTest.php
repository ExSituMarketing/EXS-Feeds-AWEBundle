<?php

namespace EXS\FeedsAWEBundle\Tests\Service;

use EXS\FeedsAWEBundle\Service\FeedsReader;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class FeedsReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $rawResponse = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<online_performers version="1.4">
 <category name="Girls">
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[HunnyStarling]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[2.49]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Here You are! My romantic, lonely boy - I must tell, You just found the cure - let's talk and play together - so I can make You feel much better.]]></bio>
   <turnon><![CDATA[Kind, smart men with good sense of humor can glamour me. If You are one of those I definitely want You to visit me :o]]></turnon>
   <turnoff><![CDATA[I do not like to be alone. Please be my company.]]></turnoff>
   <age><![CDATA[27]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[above average]]></build>
   <hairlength><![CDATA[shoulder length]]></hairlength>
   <haircolor><![CDATA[black]]></haircolor>
   <eyecolor><![CDATA[blue]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[straight]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,tatoo,stockings,anal_sex,dildo,vibrator,striptease,dancing,cameltoe,smoke_cigarette,squirt,zoom,close_up,roleplay,fingering,live_orgasm,oil,snapshot,office]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Hu/HunnyStarling/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Hu/HunnyStarling/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Hu/HunnyStarling/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Hu/HunnyStarling/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Hu/HunnyStarling/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/HunnyStarling?psid=rabbit&pstour=t1&psprogram=REVS&performerid=HunnyStarling&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[sellenastar]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[2.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[hmm unfortunatly i dont have much space to describe myself,but believe  me i am very lovable! Promise me you wont fall in love ! kiss]]></bio>
   <turnon><![CDATA[I like it when you treat me like a real person, like a real woman and when you push all the right buttons.]]></turnon>
   <turnoff><![CDATA[I dont like it when you don't tell me everything you dream and   keep your fantasies for you, I am a good confident :D]]></turnoff>
   <age><![CDATA[30]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[athletic]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[black]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,stockings,anal_sex,dildo,vibrator,love_balls,striptease,dancing,cameltoe,zoom,close_up,roleplay,fingering,butt_plug,live_orgasm,oil,snapshot]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/s/se/sellenastar/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/s/se/sellenastar/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/s/se/sellenastar/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/s/se/sellenastar/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/s/se/sellenastar/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/sellenastar?psid=rabbit&pstour=t1&psprogram=REVS&performerid=sellenastar&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[BrianaRoberts]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[2.49]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Visit my very erotic and lustful world where all of Your fantasies will come true. I want You to indulge me, explore my body!I'm waiting for You to make sure You will remember me.]]></bio>
   <turnon><![CDATA[My sexual appetite cannot be satisfied - all I want is sex! Preferably right now! - Come and guide my hands through the Land of Desire.]]></turnon>
   <turnoff><![CDATA[Unkind manner and lack of courtesy.]]></turnoff>
   <age><![CDATA[22]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[obese]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[brown]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[huge]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[shaved,stockings,dildo,striptease,dancing,smoke_cigarette,zoom,close_up,roleplay,fingering,live_orgasm,oil,snapshot]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/B/Br/BrianaRoberts/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/B/Br/BrianaRoberts/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/B/Br/BrianaRoberts/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/B/Br/BrianaRoberts/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/B/Br/BrianaRoberts/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/BrianaRoberts?psid=rabbit&pstour=t1&psprogram=REVS&performerid=BrianaRoberts&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[Monicaxo23]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[1.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Blindfold Your eyes and make a step forward, enter into the pulsing Room of Kinkiness, I'm Alice and my room is WonderLand, I will show You everything that's worth to see, HunnyBunny. Dare to step forward, I'll be there.]]></bio>
   <turnon><![CDATA[My heart will melt if You dance for me :o]]></turnon>
   <turnoff><![CDATA[A machine can be turned off...  I cannot be ! If You play nice I'll squeeze every last drop of Your precious liquid out of Your system. It worth to treat me well, I think. ;o)]]></turnoff>
   <age><![CDATA[26]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[average]]></build>
   <hairlength><![CDATA[bald]]></hairlength>
   <haircolor><![CDATA[fire red]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[straight]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[shaved,tatoo,stockings,dildo,vibrator,striptease,dancing,cameltoe,smoke_cigarette,zoom,close_up,fingering,live_orgasm,snapshot]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/M/Mo/Monicaxo23/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/M/Mo/Monicaxo23/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/M/Mo/Monicaxo23/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/M/Mo/Monicaxo23/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/M/Mo/Monicaxo23/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/Monicaxo23?psid=rabbit&pstour=t1&psprogram=REVS&performerid=Monicaxo23&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[aphr0dyte]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[1.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Open minded girl seeking for her knight to explore the Land of Pleasure. Do You know any adventurous volunteer, Big Boy ? ;o]]></bio>
   <turnon><![CDATA[My enormous bosoms and extremely hard nipples were truly created to be sucked... by You! Wanna try me? - Click on the button called Private Show.]]></turnon>
   <turnoff><![CDATA[A machine can be turned off...  I cannot be ! If You play nice I'll squeeze every last drop of Your precious liquid out of Your system. It worth to treat me well, I think. ;o)]]></turnoff>
   <age><![CDATA[25]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[athletic]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[black]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[huge]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,tatoo,stockings,anal_sex,dildo,striptease,dancing,smoke_cigarette,squirt,zoom,close_up,roleplay,fingering,live_orgasm,oil,snapshot]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/a/ap/aphr0dyte/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/a/ap/aphr0dyte/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/a/ap/aphr0dyte/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/a/ap/aphr0dyte/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/a/ap/aphr0dyte/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/aphr0dyte?psid=rabbit&pstour=t1&psprogram=REVS&performerid=aphr0dyte&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[AlessiaRosse]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[2.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[I am a little kitty, even spoilled you can say. Well, I spoil myself, but you can do it to, haha! I know how to give attention and I like the attention too. Don't shy away from saying hi.]]></bio>
   <turnon><![CDATA[I like being protected, feeling safe and making me feel like this ... it will for sure turn me on. The attitude means a lot for me. Be a man!]]></turnon>
   <turnoff><![CDATA[I hate being ignored so when you start something  with me, finish it on a nice tone.]]></turnoff>
   <age><![CDATA[24]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[athletic]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[auburn]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,piercing,tatoo,stockings,striptease,dancing,cameltoe,zoom,close_up,roleplay,fingering,live_orgasm,oil,snapshot,bathroom,kitchen,office]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/Al/AlessiaRosse/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/Al/AlessiaRosse/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/Al/AlessiaRosse/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/Al/AlessiaRosse/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/Al/AlessiaRosse/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/AlessiaRosse?psid=rabbit&pstour=t1&psprogram=REVS&performerid=AlessiaRosse&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English,Spanish]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[HornySugarCane]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[3.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Welcome ,I dont need say some about me that must say others i just want u enjoy time with me .I also like talk about ur dreams and naughty things yea . So please let me invite u in my private and u wil never forget]]></bio>
   <turnon><![CDATA[mmm for first When i see man with me enjoy time here for secound when is lover gently and slowly mmm i dont like when hurry in bed heheheheh have fun]]></turnon>
   <turnoff><![CDATA[When someone loses his mood and stops before we finish.I try for best here so be nice to me and u will see how wild i can be muahh pls dear dont start pvt with words GET NAKED it really turns me off.]]></turnoff>
   <age><![CDATA[30]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[athletic]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[other]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,stockings,anal_sex,dildo,vibrator,love_balls,striptease,dancing,cameltoe,squirt,zoom,close_up,roleplay,fingering,butt_plug,live_orgasm,oil,snapshot]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Ho/HornySugarCane/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Ho/HornySugarCane/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Ho/HornySugarCane/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Ho/HornySugarCane/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/H/Ho/HornySugarCane/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/HornySugarCane?psid=rabbit&pstour=t1&psprogram=REVS&performerid=HornySugarCane&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English,Italian]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[berrenicexx]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[2.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Hey there. I'm a foxy girl with a strong personality, looking for a good time. Free your mind, join my room and follow me into your deepest fantasies. ]]></bio>
   <turnon><![CDATA[I like erotic games and watching you enjoying it. Kind, nice men with a good sense of humor can definitely turn me on :P It's all about the tease...I love teasing you, but I love it more when you do it to me too.]]></turnon>
   <turnoff><![CDATA[Your words mean nothing when your actions are the complete opposite.]]></turnoff>
   <age><![CDATA[26]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[average]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[fire red]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,piercing,stockings,dildo,vibrator,dancing,cameltoe,smoke_cigarette,strap_on,zoom,close_up,roleplay,fingering,live_orgasm,oil,snapshot]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/b/be/berrenicexx/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/b/be/berrenicexx/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/b/be/berrenicexx/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/b/be/berrenicexx/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/b/be/berrenicexx/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/berrenicexx?psid=rabbit&pstour=t1&psprogram=REVS&performerid=berrenicexx&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[ASIANlovelyJOY]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[1.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[I am joy 35 frm phil,a Sensual Turned-On Vixen ready to get Naked with you in my Bedroom.  Tell me Exactly what is on your Mind when you see me.... I am very open-minded & love trying anything & everything!]]></bio>
   <turnon><![CDATA[i like to do Anal sex, Butt plug, Cameltoe, Close up, Dancing, Dildo, Fingering, Live orgasm, Love balls/beads, Oil, Roleplay, Smoking, Squirt, Strap on, Striptease, Vibrator, Zoom, Long nails, Shaved, Piercing, Stockings]]></turnon>
   <turnoff><![CDATA[i hate cheating,I DONT CARE IF U ARE WHITE OR BLACK AS LONG AS UR KIND AND HAVING A SENCE OF HUMOR U ARE MY ******** THAT I LOOKING FOR:) LOOKING FOR SOME ONE THAT HAVING A GOOD HEART LOVE SEX,AND TO BE WITH ME FOREVER...]]></turnoff>
   <age><![CDATA[36]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[petite]]></build>
   <hairlength><![CDATA[long]]></hairlength>
   <haircolor><![CDATA[black]]></haircolor>
   <eyecolor><![CDATA[brown]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[asian]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,stockings,anal_sex,dildo,vibrator,love_balls,dancing,cameltoe,smoke_cigarette,squirt,strap_on,zoom,close_up,roleplay,fingering,butt_plug,live_orgasm,oil,snapshot,bathroom,kitchen,office]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/AS/ASIANlovelyJOY/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/AS/ASIANlovelyJOY/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/AS/ASIANlovelyJOY/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/AS/ASIANlovelyJOY/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/A/AS/ASIANlovelyJOY/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/ASIANlovelyJOY?psid=rabbit&pstour=t1&psprogram=REVS&performerid=ASIANlovelyJOY&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
  <performerinfo>
   <category><![CDATA[Girls]]></category>
   <subcategory><![CDATA[Big_Tits]]></subcategory>
   <SB><![CDATA[1]]></SB>
   <languages><![CDATA[English,French,Italian,Spanish]]></languages>
   <site><![CDATA[jsm]]></site>
   <performerid><![CDATA[EvilCruellaXXX]]></performerid>
   <audio><![CDATA[1]]></audio>
   <chargeamount><![CDATA[1.99]]></chargeamount>
   <superhighquality><![CDATA[1]]></superhighquality>
   <onlinestatus><![CDATA[1]]></onlinestatus>
   <watmb><![CDATA[1]]></watmb>
   <bio><![CDATA[Welcome into the enchanting Room of Kinkiness and Evil, I can be your sensual lady,your worshipping mistress or your naughtyl little girl! It 's all up to you my lover!!!]]></bio>
   <turnon><![CDATA[I incredibly like hard cocks and analI've got the perfect juicy ass.Join me ,i will guide you to a marvellous lustfull world. At  the end,all i want  to say is WOW,,,,let's do this again and again,,all night love!]]></turnon>
   <turnoff><![CDATA[Always say HI and BYE!This squirting machine can t be stopped easilly ,treat me good and politely cause i can  make all your naughty fantasies come true! I'm a girl with attitude,not a dummy!]]></turnoff>
   <age><![CDATA[27]]></age>
   <height><![CDATA[N/A]]></height>
   <weight><![CDATA[N/A]]></weight>
   <build><![CDATA[average]]></build>
   <hairlength><![CDATA[shoulder length]]></hairlength>
   <haircolor><![CDATA[fire red]]></haircolor>
   <eyecolor><![CDATA[green]]></eyecolor>
   <penissize><![CDATA[N/A]]></penissize>
   <breastsize><![CDATA[big]]></breastsize>
   <sexpref><![CDATA[bisexual]]></sexpref>
   <sex><![CDATA[female]]></sex>
   <ethnicity><![CDATA[white]]></ethnicity>
   <willingness><![CDATA[long_nails,shaved,piercing,stockings,anal_sex,dildo,vibrator,love_balls,striptease,dancing,cameltoe,smoke_cigarette,squirt,strap_on,zoom,close_up,roleplay,fingering,butt_plug,live_orgasm,oil,snapshot,bathroom,kitchen,office,bar,garden]]></willingness>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/E/Ev/EvilCruellaXXX/pimage1.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/E/Ev/EvilCruellaXXX/pimage2.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/E/Ev/EvilCruellaXXX/pimage3.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/E/Ev/EvilCruellaXXX/pimage4.jpg]]></picture>
   <picture><![CDATA[http://static.awempire.com/jsm/_profile/E/Ev/EvilCruellaXXX/pimage5.jpg]]></picture>
   <link><![CDATA[http://new.livejasmin.com/chat/EvilCruellaXXX?psid=rabbit&pstour=t1&psprogram=REVS&performerid=EvilCruellaXXX&pstool=12_3&campaign_id=34751]]></link>
  </performerinfo>
 </category>
</online_performers>
XML;

    /**
     * @var array
     */
    private $arrayResponse = [
        "HunnyStarling",
        "sellenastar",
        "BrianaRoberts",
        "Monicaxo23",
        "aphr0dyte",
        "AlessiaRosse",
        "HornySugarCane",
        "berrenicexx",
        "ASIANlovelyJOY",
        "EvilCruellaXXX",
    ];

    public function testGetLivePerformers()
    {
        $memcached = $this->prophesize(\Memcached::class);
        $memcached->get('AWELivePerformers')->willReturn(false)->shouldBeCalledTimes(1);
        $memcached->set('AWELivePerformers', $this->arrayResponse, 300)->shouldBeCalledTimes(1);

        $body = $this->prophesize(StreamInterface::class);
        $body->getContents()->willReturn($this->rawResponse)->shouldBeCalledTimes(1);

        $response = $this->prophesize(ResponseInterface::class);
        $response->getStatusCode()->willReturn(200)->shouldBeCalledTimes(1);
        $response->getBody()->willReturn($body)->shouldBeCalledTimes(1);

        $httpClient = $this->prophesize(Client::class);
        $httpClient->get('http://live-cams-2.livejasmin.com/allonline/?site=jsm&psid=rabbit&campaign_id=34751&pstour=t1&psprogram=REVS&landing_page=freechat&image_count=5&image_size=full&flags=1&willingness=1&allmodels=0', [
            'headers' => ['Accept' => 'application/xml'],
            'timeout' => 10.0,
            'http_errors' => false,
        ])->willReturn($response)->shouldBeCalledTimes(1);

        $reader = new FeedsReader($memcached->reveal(), $httpClient->reveal());

        $result = $reader->getLivePerformers();

        $this->assertCount(10, $result);
        $this->assertEquals('BrianaRoberts', $result[2]);
        $this->assertEquals('aphr0dyte', $result[4]);
    }

    public function testGetLivePerformersWhenAnExceptionOccurs()
    {
        $memcached = $this->prophesize(\Memcached::class);
        $memcached->get('AWELivePerformers')->willReturn(false)->shouldBeCalledTimes(1);

        $httpClient = $this->prophesize(Client::class);
        $httpClient->get('http://live-cams-2.livejasmin.com/allonline/?site=jsm&psid=rabbit&campaign_id=34751&pstour=t1&psprogram=REVS&landing_page=freechat&image_count=5&image_size=full&flags=1&willingness=1&allmodels=0', [
            'headers' => ['Accept' => 'application/xml'],
            'timeout' => 10.0,
            'http_errors' => false,
        ])->willThrow(new \RuntimeException("It's a trap!"))->shouldBeCalledTimes(1);

        $reader = new FeedsReader($memcached->reveal(), $httpClient->reveal());

        $result = $reader->getLivePerformers();

        $this->assertEmpty($result);
    }
}
