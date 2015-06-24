<?php

/**
 * Core modules
 * @package modules
 * @subpackage core
 */

if (!defined('DEBUG_MODE')) { die(); }

/**
 * Close the session before it's automatically closed at the end of page processing
 * @subpackage core/handler
 */
class Hm_Handler_close_session_early extends Hm_Handler_Module {
    /***
     * Uses the close_early method of the session this->session object
     */
    public function process() {
        $this->session->close_early();
    }
}

/**
 * Build a list of HTTP headers to output to the browser
 * @subpackage core/handler
 */
class Hm_Handler_http_headers extends Hm_Handler_Module {
    /***
     * These are pretty restrictive, but the idea is to have a secure starting point
     */
    public function process() {
        $headers = array();
        if ($this->get('language')) {
            $headers[] = 'Content-Language: '.substr($this->get('language'), 0, 2);
        }
        if ($this->request->tls) {
            $headers[] = 'Strict-Transport-Security: max-age=31536000';
        }
        $headers[] = 'X-XSS-Protection: 1; mode=block';
        $headers[] = 'X-Content-Type-Options: nosniff';
        $headers[] = 'Expires: '.gmdate('D, d M Y H:i:s \G\M\T', strtotime('-1 year'));
        $headers[] = "Content-Security-Policy: default-src 'none'; script-src 'self' 'unsafe-inline'; connect-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline';";
        if ($this->request->type == 'AJAX') {
            $headers[] = 'Content-Type: application/json';
        }
        $this->out('http_headers', $headers);
    }
}

/**
 * Process input from the the list style setting in the general settings section.
 * @subpackage core/handler
 */
class Hm_Handler_process_list_style_setting extends Hm_Handler_Module {

    /**
     * Can be one of two values, 'email_style' or 'list_style'. The default is 'email_style'.
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'list_style'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            if (in_array($form['list_style'], array('email_style', 'news_style'))) {
                $new_settings['list_style'] = $form['list_style'];
            }
            else {
                $settings['list_style'] = $this->user_config->get('list_style', false);
            }
        }
        else {
            $settings['list_style'] = $this->user_config->get('list_style', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process input from the max per source setting for the Unread page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_unread_source_max_setting extends Hm_Handler_Module {
    /**
     * Allowed values are greater than zero and less than MAX_PER_SOURCE
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'unread_per_source'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            if ($form['unread_per_source'] > MAX_PER_SOURCE || $form['unread_per_source'] < 0) {
                $sources = DEFAULT_PER_SOURCE;
            }
            else {
                $sources = $form['unread_per_source'];
            }
            $new_settings['unread_per_source_setting'] = $sources;
        }
        else {
            $settings['unread_per_source'] = $this->user_config->get('unread_per_source_setting', DEFAULT_PER_SOURCE);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process input from the max per source setting for the All E-mail page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_all_email_source_max_setting extends Hm_Handler_Module {
    /**
     * Allowed values are greater than zero and less than MAX_PER_SOURCE
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'all_email_per_source'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            if ($form['all_email_per_source'] > MAX_PER_SOURCE || $form['all_email_per_source'] < 0) {
                $sources = DEFAULT_PER_SOURCE;
            }
            else {
                $sources = $form['all_email_per_source'];
            }
            $new_settings['all_email_per_source_setting'] = $sources;
        }
        else {
            $settings['all_email_per_source'] = $this->user_config->get('all_email_per_source_setting', DEFAULT_PER_SOURCE);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process input from the max per source setting for the Everything page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_all_source_max_setting extends Hm_Handler_Module {
    /**
     * Allowed values are greater than zero and less than MAX_PER_SOURCE
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'all_per_source'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            if ($form['all_per_source'] > MAX_PER_SOURCE || $form['all_per_source'] < 0) {
                $sources = DEFAULT_PER_SOURCE;
            }
            else {
                $sources = $form['all_per_source'];
            }
            $new_settings['all_per_source_setting'] = $sources;
        }
        else {
            $settings['all_per_source'] = $this->user_config->get('all_per_source_setting', DEFAULT_PER_SOURCE);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process input from the max per source setting for the Flagged page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_flagged_source_max_setting extends Hm_Handler_Module {
    /**
     * Allowed values are greater than zero and less than MAX_PER_SOURCE
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'flagged_per_source'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            if ($form['flagged_per_source'] > MAX_PER_SOURCE || $form['flagged_per_source'] < 0) {
                $sources = DEFAULT_PER_SOURCE;
            }
            else {
                $sources = $form['flagged_per_source'];
            }
            $new_settings['flagged_per_source_setting'] = $sources;
        }
        else {
            $settings['flagged_per_source'] = $this->user_config->get('flagged_per_source_setting', DEFAULT_PER_SOURCE);
        }
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());
    }
}

/**
 * Process "since" setting for the Flagged page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_flagged_since_setting extends Hm_Handler_Module {
    /**
     * valid values are defined in the process_since_argument function
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'flagged_since'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            $new_settings['flagged_since_setting'] = process_since_argument($form['flagged_since'], true);
        }
        else {
            $settings['flagged_since'] = $this->user_config->get('flagged_since_setting', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process "since" setting for the Everything page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_all_since_setting extends Hm_Handler_Module {
    /**
     * valid values are defined in the process_since_argument function
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'all_since'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            $new_settings['all_since_setting'] = process_since_argument($form['all_since'], true);
        }
        else {
            $settings['all_since'] = $this->user_config->get('all_since_setting', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process "since" setting for the All E-mail page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_all_email_since_setting extends Hm_Handler_Module {
    /**
     * valid values are defined in the process_since_argument function
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'all_email_since'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            $new_settings['all_email_since_setting'] = process_since_argument($form['all_email_since'], true);
        }
        else {
            $settings['all_email_since'] = $this->user_config->get('all_email_since_setting', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process "since" setting for the Unread page in the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_unread_since_setting extends Hm_Handler_Module {
    /**
     * valid values are defined in the process_since_argument function
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'unread_since'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            $new_settings['unread_since_setting'] = process_since_argument($form['unread_since'], true);
        }
        else {
            $settings['unread_since'] = $this->user_config->get('unread_since_setting', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process language setting from the general section of the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_language_setting extends Hm_Handler_Module {
    /**
     * @todo add validation
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'language_setting'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            $new_settings['language_setting'] = $form['language_setting'];
        }
        else {
            $settings['language'] = $this->user_config->get('language_setting', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Process the timezone setting from the general section of the settings page
 * @subpackage core/handler
 */
class Hm_Handler_process_timezone_setting extends Hm_Handler_Module {
    /**
     * @todo: add validation
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings', 'timezone_setting'));
        $new_settings = $this->get('new_user_settings', array());
        $settings = $this->get('user_settings', array());

        if ($success) {
            $new_settings['timezone_setting'] = $form['timezone_setting'];
        }
        else {
            $settings['timezone'] = $this->user_config->get('timezone_setting', false);
        }
        $this->out('new_user_settings', $new_settings, false);
        $this->out('user_settings', $settings, false);
    }
}

/**
 * Save user settings permanently
 * @subpackage core/handler
 */
class Hm_Handler_process_save_form extends Hm_Handler_Module {
    /**
     * save any changes since login to permanent storage
     */
    public function process() {
        list($success, $form) = $this->process_form(array('password'));
        $save = false;
        $logout = false;
        if ($success) {
            if (array_key_exists('save_settings_permanently', $this->request->post)) {
                $save = true;
            }
            elseif (array_key_exists('save_settings_permanently_then_logout', $this->request->post)) {
                $save = true;
                $logout = true;
            }
            if ($save) {
                $user = $this->session->get('username', false);
                $path = $this->config->get('user_settings_dir', false);

                if ($this->session->auth($user, $form['password'])) {
                    $pass = $form['password'];
                }
                else {
                    Hm_Msgs::add('ERRIncorrect password, could not save settings to the server');
                    $pass = false;
                }
                if ($user && $path && $pass) {
                    $this->user_config->save($user, $pass);
                    $this->session->set('changed_settings', array());
                    if ($logout) {
                        $this->session->destroy($this->request);
                        Hm_Msgs::add('Saved user data on logout');
                        Hm_Msgs::add('Session destroyed on logout');
                    }
                    else {
                        Hm_Msgs::add('Settings saved');
                    }
                }
            }
        }
    }
}

/**
 * Save settings from the settings page to the session
 * @subpackage core/handler
 */
class Hm_Handler_save_user_settings extends Hm_Handler_Module {
    /**
     * save new site settings to the session
     */
    public function process() {
        list($success, $form) = $this->process_form(array('save_settings'));
        if ($success) {
            if ($new_settings = $this->get('new_user_settings', array())) {
                foreach ($new_settings as $name => $value) {
                    $this->user_config->set($name, $value);
                }
                Hm_Page_Cache::flush($this->session);
                Hm_Msgs::add('Settings saved');
                $this->session->record_unsaved('Site settings updated');
                $this->out('reload_folders', true, false);
            }
        }
        /*elseif (array_key_exists('save_settings', $this->request->post)) {
            Hm_Msgs::add('ERRYour password is required to save your settings to the server');
        }*/
    }
}

/**
 * Setup a default title
 * @subpackage core/handler
 */
class Hm_Handler_title extends Hm_Handler_Module {
    /**
     * output a default title based on the page URL argument
     */
    public function process() {
        $this->out('title', ucfirst($this->page));
    }
}

/**
 * Setup the current language
 * @subpackage core/handler
 */
class Hm_Handler_language extends Hm_Handler_Module {
    /**
     * output the user configured language or English if not set
     */
    public function process() {
        $this->out('language', $this->user_config->get('language_setting', 'en'));
    }
}

/**
 * Setup the date
 * @subpackage core/handler
 */
class Hm_Handler_date extends Hm_Handler_Module {
    /**
     * output a simple date string
     */
    public function process() {
        $this->out('date', date('G:i:s'));
    }
}

/**
 * Process a potential login attempt
 * @subpackage core/handler
 */
class Hm_Handler_login extends Hm_Handler_Module {
    /**
     * Perform a new login if the form was submitted, otherwise check for and continue a session if it exists
     */
    public function process() {
        if (!$this->get('create_username', false)) {
            list($success, $form) = $this->process_form(array('username', 'password'));
            if ($success) {
                $this->session->check($this->request, rtrim($form['username']), $form['password']);
                $this->session->set('username', rtrim($form['username']));
            }
            else {
                $this->session->check($this->request);
            }
            if ($this->session->is_active()) {
                Hm_Page_Cache::load($this->session);
                $this->out('changed_settings', $this->session->get('changed_settings', array()), false);
            }
        }
        $this->process_key();
    }
}

/**
 * Setup default page data
 * @subpackage core/handler
 */
class Hm_Handler_default_page_data extends Hm_Handler_Module {
    /**
     * For now the data_sources array is the only default
     */
    public function process() {
        $this->out('data_sources', array(), false);
    }
}

/**
 * Load user data
 * @subpackage core/handler
 */
class Hm_Handler_load_user_data extends Hm_Handler_Module {
    /**
     * Load data from persistant storage on login, or from the session if already logged in
     */
    public function process() {
        list($success, $form) = $this->process_form(array('username', 'password'));
        if ($this->session->is_active()) {
            if ($success) {
                $this->user_config->load(rtrim($form['username']), $form['password']);
            }
            else {
                $user_data = $this->session->get('user_data', array());
                if (!empty($user_data)) {
                    $this->user_config->reload($user_data);
                }
                $pages = $this->user_config->get('saved_pages', array());
                if (!empty($pages)) {
                    $this->session->set('saved_pages', $pages);
                }
            }
        }
        $this->out('is_mobile', $this->request->mobile);
    }
}

/**
 * Save user data to the session
 * @subpackage core/handler
 */
class Hm_Handler_save_user_data extends Hm_Handler_Module {
    /**
     * @todo rename to make it obvious this is session only
     */
    public function process() {
        $user_data = $this->user_config->dump();
        if (!empty($user_data)) {
            $this->session->set('user_data', $user_data);
        }
    }
}

/**
 * Process a logout
 * @subpackage core/handler
 */
class Hm_Handler_logout extends Hm_Handler_Module {
    /**
     * Clean up everything on logout
     */
    public function process() {
        if (array_key_exists('logout', $this->request->post) && !$this->session->loaded) {
            $this->session->destroy($this->request);
            Hm_Msgs::add('Session destroyed on logout');
        }
        elseif (array_key_exists('save_and_logout', $this->request->post)) {
            list($success, $form) = $this->process_form(array('password'));
            if ($success) {
                $user = $this->session->get('username', false);
                $path = $this->config->get('user_settings_dir', false);
                $pages = $this->session->get('saved_pages', array());
                if (!empty($pages)) {
                    $this->user_config->set('saved_pages', $pages);
                }
                if ($this->session->auth($user, $form['password'])) {
                    $pass = $form['password'];
                }
                else {
                    Hm_Msgs::add('ERRIncorrect password, could not save settings to the server');
                    $pass = false;
                }
                if ($user && $path && $pass) {
                    $this->user_config->save($user, $pass);
                    $this->session->destroy($this->request);
                    Hm_Msgs::add('Saved user data on logout');
                    Hm_Msgs::add('Session destroyed on logout');
                }
            }
            else {
                Hm_Msgs::add('ERRYour password is required to save your settings to the server');
            }
        }
    }
}

/**
 * Setup the message list type based on URL arguments
 * @subpackage core/handler
 */
class Hm_Handler_message_list_type extends Hm_Handler_Module {
    /**
     * @todo clean this up somehow
     */
    public function process() {
        $uid = '';
        $list_parent = '';
        $list_page = 1;
        $list_meta = true;
        $no_list_headers = false;

        if (array_key_exists('list_path', $this->request->get)) {
            $path = $this->request->get['list_path'];
            list($list_path, $mailbox_list_title, $message_list_since, $per_source_limit) = get_message_list_settings($path, $this);
        }
        if (array_key_exists('list_parent', $this->request->get)) {
            $list_parent = $this->request->get['list_parent'];
        }
        if (array_key_exists('list_page', $this->request->get)) {
            $list_page = (int) $this->request->get['list_page'];
            if ($list_page < 1) {
                $list_page = 1;
            }
        }
        else {
            $list_page = 1;
        }
        if (array_key_exists('uid', $this->request->get) && preg_match("/\d+/", $this->request->get['uid'])) {
            $uid = $this->request->get['uid'];
        }
        $list_style = $this->user_config->get('list_style', false);
        if ($this->get('is_mobile', false)) {
            $list_style = 'news_style';
        }
        if ($list_style == 'news_style') {
            $no_list_headers = true;
            $this->out('news_list_style', true);
        }
        $this->out('uid', $uid);
        $this->out('list_path', $list_path, false);
        $this->out('list_meta', $list_meta, false);
        $this->out('list_parent', $list_parent, false);
        $this->out('list_page', $list_page, false);
        $this->out('mailbox_list_title', $mailbox_list_title, false);
        $this->out('message_list_since', $message_list_since, false);
        $this->out('per_source_limit', $per_source_limit, false);
        $this->out('no_message_list_headers', $no_list_headers);
        $this->out('message_list_fields', array(
            array('chkbox_col', false, false),
            array('source_col', 'source', 'Source'),
            array('from_col', 'from', 'From'),
            array('subject_col', 'subject', 'Subject'),
            array('date_col', 'msg_date', 'Date'),
            array('icon_col', false, false)), false);
    }
}

/**
 * Set a cookie to instruct the JS to reload the folder list
 * @subpackage core/handler
 */
class Hm_Handler_reload_folder_cookie extends Hm_Handler_Module {
    /**
     * This cookie will be deleted by JS
     */
    public function process() {
        if ($this->get('reload_folders', false)) {
            $this->session->secure_cookie($this->request, 'hm_reload_folders', '1');
        }
    }
}

/**
 * Process search terms from a URL
 * @subpackage core/handler
 */
class Hm_Handler_process_search_terms extends Hm_Handler_Module {
    /**
     * validate and set search tems in the session
     */
    public function process() {
        if (array_key_exists('search_terms', $this->request->get)) {
            $this->out('run_search', 1);
            $this->session->set('search_terms', validate_search_terms($this->request->get['search_terms']));
        }
        if (array_key_exists('search_since', $this->request->get)) {
            $this->session->set('search_since', process_since_argument($this->request->get['search_since'], true));
        }
        if (array_key_exists('search_fld', $this->request->get)) {
            $this->session->set('search_fld', validate_search_fld($this->request->get['search_fld']));
        }
        $this->out('search_since', $this->session->get('search_since', DEFAULT_SINCE));
        $this->out('search_terms', $this->session->get('search_terms', ''));
        $this->out('search_fld', $this->session->get('search_fld', 'TEXT'));
    }
}

