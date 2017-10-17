<form class="ScheduleList" action="<?=cn('ajax_action_multiple')?>">
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="fa fa-facebook-official" aria-hidden="true"></i> <?=l('Facebook accounts')?>
                    </h2>
                </div>
                <div class="header">
                	<div class="form-inline">
                        <div class="btn-group" role="group">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn bg-red waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?=l('Action')?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="btnActionModule" data-action="active" href="javascript:void(0);"><?=l('Active')?></a></li>
                                    <li><a class="btnActionModule" data-action="disable" href="javascript:void(0);"><?=l('Deactive')?></a></li>
                                    <li><a class="btnActionModule" data-action="delete" data-confirm="<?=l('Are you sure you want to delete this items?')?>" href="javascript:void(0);"><?=l('Delete')?></a></li>
                                </ul>
                            </div>
                            <a href="<?=url('facebook_accounts/update')?>" class="btn bg-light-green waves-effect"><i class="fa fa-plus" aria-hidden="true"></i> <?=l('Add new')?></a>
                        </div>
                    </div>
                </div>
                <div class="body p0">
                    <table class="table table-bordered table-striped table-hover js-dataTable dataTable mb0">
                        <thead>
                            <tr>
                                <th style="width: 10px;">
                                    <input type="checkbox" id="md_checkbox_211" class="filled-in chk-col-red checkAll">
                                    <label class="p0 m0" for="md_checkbox_211">&nbsp;</label>
                                </th>
                                <?php if(IS_ADMIN == 1){?>
                                <th><?=l('User')?></th>
                                <?php }?>
                                <th><?=l('Facebook ID')?></th>
                                <th><?=l('Fullname')?></th>
                                <th><?=l('Username')?></th> 
                                <th><?=l('Token')?></th>
                                <th class="text-center"><?=l('Update Groups/Pages/Liked Pages')?></th>
                                <th><?=l('Status')?></th>
                                <th><?=l('Option')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($result)){
                            foreach ($result as $key => $row) {
                            ?>
                            <tr class="pending" data-action="<?=cn('ajax_action_item')?>" data-action-groups="<?=cn('ajax_get_groups')?>" data-id="<?=$row->id?>">
                                <td>
                                    <input type="checkbox" name="id[]" id="md_checkbox_<?=$key?>" class="filled-in chk-col-red checkItem" value="<?=$row->id?>">
                                    <label class="p0 m0" for="md_checkbox_<?=$key?>">&nbsp;</label>
                                </td>
                                <?php if(IS_ADMIN == 1){?>
                                <td><a href="<?=url('user_management/update?id='.$row->uid)?>"><?=$row->user?></a></td>
                                <?php }?>
                                <td><a href="https://facebook.com/<?=$row->fid?>" target="_blank"><?=$row->fid?></a></td>
                                <td><?=$row->fullname?></td>
                                <td><?=$row->username?></td>
                                <td><?=$row->token_name?></td>
                                <td class="text-center"><button type="button" data-toggle="modal" data-target="#UpdateGroups" class="btn bg-light-blue waves-effect btnUpdateGroupsID" data-type="group"><?=l('Update')?></button></td>
                                <td style="width: 60px;">
                                    <div class="switch">
                                        <label><input type="checkbox" class="btnActionModuleItem" <?=$row->status==1?"checked":""?>><span class="lever switch-col-light-blue"></span></label>
                                    </div>
                                </td>
                                <td style="width: 80px;">
                                    <div class="btn-group" role="group">
                                        <a href="<?=url('facebook_accounts/update?id='.$row->id)?>" class="btn bg-light-green waves-effect"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <button type="button" class="btn bg-light-green waves-effect btnActionModuleItem" data-action="delete" data-confirm="<?=l('Are you sure you want to delete this item?')?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php }}?>
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade box-modal" id="UpdateGroups" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-login modal-dialog" role="document" >
      <div class="modal-content">
          <div class="modal-header bg-light-green">
              <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-facebook-official" aria-hidden="true"></i> <?=l('Update Groups/Pages/Liked Pages')?></h4>
          </div>
          <div class="modal-body">
              <div class="body">
                    <form action="<?=url('facebook_accounts/ajax_update_groups')?>" data-redirect="<?=current_url()?>">
                        <b><?=l('Graph API Explorer')?></b>
                        <table class="table table-bordered">
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn bg-light-green waves-effect btnAllowPermission" data-appid="https://www.facebook.com/v1.0/dialog/oauth?redirect_uri=https%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&scope=email,publish_actions,publish_pages,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&response_type=token,code&client_id=145634995501895">Allow Permissions</button>
                                    <br/>
                                </td>
                            <tr>
                            </tr>
                                <td class="text-center">
                                    <input style="max-width: 200px; display: inline-block;" type="text" onclick="this.select();" class="form-control" id="app1" value="view-source:https://www.facebook.com/v2.8/dialog/oauth?redirect_uri=https%3A%2F%2Fwww.facebook.com%2Fconnect%2Flogin_success.html&amp;scope=email,publish_actions,publish_pages,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&amp;response_type=token&amp;sso_key=com&amp;client_id=145634995501895&amp;_rdr">
                                </td>
                            </tr>
                            </tr>
                                <td class="text-center">
                                    <input type="hidden" class="update_groups_id" name="id" value=""/>
                                    <textarea name="access_token" class="form-control" rows="3" placeholder="Enter Graph API Explorer Access Token"></textarea>
                                </td>
                            </tr>
                        </table>
                        <br/> 
                        <button type="button" class="btn bg-light-green waves-effect btnActionUpdate" ><?=l('Update')?></button>
                  </form>
              </div>
          </div>
          <div class="modal-footer">
              
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    $(function(){
        $(".btnUpdateGroupsID").click(function(){
            _id = $(this).parents("tr").data("id");
            $(".update_groups_id").val(_id);
        });
    });
</script>