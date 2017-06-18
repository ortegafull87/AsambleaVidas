<!--
==================== Respmail ====================
Licensed under MIT (https://github.com/charlesmudy/responsive-html-email-template/blob/master/LICENSE)
Designed by Shina Charles Memud
Respmail v1.2 (http://charlesmudy.com/respmail/)
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
@include('layouts.partials.mail.head')
<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

<!-- CENTER THE EMAIL // -->
<!--
1.  The center tag should normally put all the
    content in the middle of the email page.
    I added "table-layout: fixed;" style to force
    yahoomail which by default put the content left.
2.  For hotmail and yahoomail, the contents of
    the email starts from this center, so we try to
    apply necessary styling e.g. background-color.
-->
<center style="background-color:#E1E1E1;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable"
           style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
        <tr>
            <td align="center" valign="top" id="bodyCell">

                <!-- EMAIL HEADER // -->
                <!--
                    The table "emailBody" is the email's container.
                    Its width can be set to 100% for a color band
                    that spans the width of the page.
                -->
                <table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader">

                    <!-- // LOGO -->
                    <tr>
                        <td align="center" valign="top">
                            <!-- CENTERING TABLE // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="500"
                                               class="flexibleContainer">
                                            <tr>
                                                <td align="center" valign="top" width="500"
                                                    class="flexibleContainerCell">
                                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td valign="top" bgcolor="#E1E1E1">
                                                                <div style="text-align:center; width100%;">
                                                                    <img src="http://pre.vivelatorah.org/public/legal/baner-mail.png"
                                                                         style="display:block; margin:auto;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>

                </table>
                <!-- // LOGO END -->

                <!-- EMAIL BODY // -->
                <!--
                    The table "emailBody" is the email's container.
                    Its width can be set to 100% for a color band
                    that spans the width of the page.
                -->
                <table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">


                    <!-- MODULE ROW // -->
                    <!--  The "mc:hideable" is a feature for MailChimp which allows
                        you to disable certain row. It works perfectly for our row structure.
                        http://kb.mailchimp.com/article/template-language-creating-editable-content-areas/
                    -->


                    <!-- MODULE ROW // -->
                    <tr>
                        <td align="center" valign="top">
                            <!-- CENTERING TABLE // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F8F8F8">
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="500"
                                               class="flexibleContainer">
                                            <tr>
                                                <td align="center" valign="top" width="500"
                                                    class="flexibleContainerCell">
                                                    <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="center" valign="top">

                                                                <!-- CONTENT TABLE // -->
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td valign="top" class="textContent">
                                                                            <!--
                                                                                The "mc:edit" is a feature for MailChimp which allows
                                                                                you to edit certain row. It makes it easy for you to quickly edit row sections.
                                                                                http://kb.mailchimp.com/templates/code/create-editable-content-areas-with-mailchimps-template-language
                                                                            -->
                                                                            @include('layouts.partials.mail.headmail')

                                                                            @include('layouts.partials.mail.section')

                                                                            @yield('extraCont')
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <!-- // CONTENT TABLE -->

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>
                    <!-- // MODULE ROW -->


                    <!-- MODULE ROW // -->
                    <tr>
                        <td align="center" valign="top">
                            <!-- CENTERING TABLE // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- FLEXIBLE CONTAINER // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="500"
                                               class="flexibleContainer">
                                            <tr>
                                                <td align="center" valign="top" width="500"
                                                    class="flexibleContainerCell">
                                                    <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="center" valign="top">
                                                                @include('layouts.partials.mail.socials')
                                                            </td>
                                                        </tr>
                                                        <!-- // MODULE ROW -->
                                                    </table>
                                                    <!-- // END -->
                                                    @include('layouts.partials.mail.footer')
                                                </td>
                                            </tr>
                                        </table>
</center>
</body>
</html>
