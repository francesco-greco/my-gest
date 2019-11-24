<div class="row ch_canvas">
    <div class="large-5 columns large-centered">
        <div style="margin-top: 20px; border-radius: 20px; background: #fff8dc" id="login-panel" class="panel radius">
            <div class="row">
                <div class="large-12 columns large-centered" style="text-align: center;">
                    <img style="width: 100%; border-radius: 20px;" src="<?php print_url('/images/logo.jpeg') ?>">
                </div>
            </div>

            <script type="text/javascript">
                var RecaptchaOptions = {
                    theme: 'custom',
                    custom_theme_widget: 'recaptcha_widget'
                };
            </script>

            <form method="post" action="<?php print_url(CH_URL_LOGIN . '/autenticate') ?>" class="custom">
                <div class="row" style="margin-top: 10px;">
                    <div class="large-12 columns">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="required" placeholder="<?php echo lang('login_username_label') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="required" placeholder="Password">
                    </div>
                </div>
                <!--            <div class="row">
                               <div class="large-12 columns">
                                  <div id="recaptcha_widget" style="display:none">
                                     <div id="recaptcha_image"></div>
                                     <div class="recaptcha_only_if_incorrect_sol" style="color:red"><?php echo lang('login_recapcha_error') ?></div>
                
                                     <span class="recaptcha_only_if_image"><?php echo lang('login_recapcha_enter_correct_words') ?></span>
                                     <span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
                
                                     <input type="text" id="recaptcha_response_field" class="required" name="recaptcha_response_field" />
                
                                     <div><a href="javascript:Recaptcha.reload()"><?php echo lang('login_recapcha_another_image') ?></a></div>
                                     <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')"><?php echo lang('login_recapcha_audio') ?></a></div>
                                     <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')"><?php echo lang('login_recapcha_image') ?></a></div>
                
                                     <div><a href="javascript:Recaptcha.showhelp()"><?php echo lang('common_words_help') ?></a></div>
                                  </div>
                
                                  <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo RECAPTCHA_LOCALHOST_PUBLIC_KEY ?>"></script>
                                  <noscript>
                                     <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo RECAPTCHA_LOCALHOST_PUBLIC_KEY ?>" height="300" width="500" frameborder="0"></iframe><br>
                                     <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                                     <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                                  </noscript>
                               </div>
                            </div>-->
                <div class="row">
                    <div class="large-8 columns large-centered text-center">
                        <button style="background: #1372ac; width: 200px;" type="submit" name="go" class="button round"><?php echo lang('common_words_enter') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>var page = 'login';</script>