<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        return view('dashboards.dashboard');
    }

    public function analytics(Request $request)
    {

        return view('dashboards.analytics');
    }

    /*
     * Auth pages Routs
     */

     function authLogin()
    {
    return view('auth.login');
    }

    function authRegister()
    {
        return view('auth.register');
    }

    function authRecoverPassword()
    {
        return view('auth.forgot-password');
    }

    function authConfirmEmail()
    {
        return view('auth.verify-email');
    }

    function authLockScreen()
    {
        return view();
    }

    
    /*
     * Form Page Routs
     */
    public function FormsRadio()
    {
        return view('forms.radio');
    }

    public function FormsLayout()
    {
        return view('forms.layout');
    }

    public function FormsSelect()
    {
        return view('forms.select');
    }

    public function FormsSwitch()
    {
        return view('forms.switch');
    }

    public function FormsCheckbox()
    {
        return view('forms.checkbox');
    }

    public function FormsTextarea()
    {
        return view('forms.textarea');
    }

    public function FormsValidation()
    {
        return view('forms.validation');
    }

    public function FormsInputgroup()
    {
        return view('forms.inputgroup');
    }

    /*
     * UI Page Routs
     */

    public function UiGrid()
    {
        return view('ui.grid');
    }

    public function UiTabs()
    {
        return view('ui.tabs');
    }

    public function UiCards()
    {
        return view('ui.cards');
    }

    public function UiModal()
    {
        return view('ui.modal');
    }

    public function UiAlerts()
    {
        return view('ui.alerts');
    }

    public function UiBadges()
    {
        return view('ui.badges');
    }

    public function UiColors()
    {
        return view('ui.colors');
    }

    public function UiImages()
    {
        return view('ui.images');
    }

    public function UiAvatars()
    {
        return view('ui.avatars');
    }

    public function UiButtons()
    {
        return view('ui.buttons');
    }

    public function UiCarousel()
    {
        return view('ui.carousel');
    }

    public function UiPopovers()
    {
        return view('ui.popovers');
    }

    public function UiTooltips()
    {
        return view('ui.tooltips');
    }

    public function UiBoxshadows()
    {
        return view('ui.boxshadows');
    }

    public function UiHelperClass()
    {
        return view('ui.helperclass');
    }

    public function UiBreadcrumb()
    {
        return view('ui.breadcrumb');
    }

    public function UiListgroup()
    {
        return view('ui.listgroup');
    }

    public function UiPagination()
    {
        return view('ui.pagination');
    }

    public function UiTypography()
    {
        return view('ui.typography');
    }

    public function UiMedia()
    {
        return view('ui.media');
    }

    public function UiProgressbars()
    {
        return view('ui.progressbars');
    }

    public function UiButtongroup()
    {
        return view('ui.buttongroup');
    }
    public function UiNotification()
    {
        return view('ui.notification');
    }

    public function UiVideo()
    {
        return view('ui.video');
    }

     /*
     * App Page Routs
     */

    public function Userprofile()
    {
        return view('userdetails.userprofile');
    }

    public function Useradd()
    {
        return view('userdetails.useradd');
    }

    public function Userlist()
    {
        return view('userdetails.userlist');
    }
    
    public function userProfileEdit()
    {
        return view('userdetails.userprofileedit');
    }

    public function PrivacyPolicy()
    {
        return view('userdetails.privacypolicy');
    }

    public function TermsOfUse()
    {
        return view('userdetails.termsofuse');
    }

    /*
     * Error Page Routs
     */

    public function Error404()
    {
        return view('pageError.error404');
    }

    public function Error500()
    {
        return view('pageError.error500');
    }

    
    /*
     * Timeline Page Routs
     */

    public function Pricing1()
    {
        return view('pricing.pricing1');
    }

    public function Pricing2()
    {
        return view('pricing.pricing2');
    }

    /*
     * Extra Page Routs
     */

    public function timeline()
    {
        return view('timeline');
    }

    public function BlankPages()
    {
        return view('blankpage');
    }

    public function Maintenance()
    {
        return view('maintenance');
    }


    /*
     * Table Page Routs
     */

    public function tableBasics()
    {
        return view('table.tablebasics');
    }

    public function tableData()
    {
        return view('table.tabledata');
    }

    public function tableTree()
    {
        return view('table.tabletree');
    }

}
