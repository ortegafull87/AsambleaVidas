<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
@include('layouts.partials.mail.headmail')
<body class="body" style="padding:0; margin:0; display:block; background:#f3f5f6; -webkit-text-size-adjust:none"
      bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td align="center" valign="top" bgcolor="#f3f5f6" width="100%">
            <img src="http://localhost:8000/img/app/torah-icono_4_plus_2.png" alt="" height="70"/>
            <center>
                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="600" class="w320">
                    <tr>
                        <td align="center" valign="top">
                            <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="100%"
                                   style="margin:0 auto;">
                                <tr>
                                    <td style="font-size: 30px; text-align:center;">
                                        @yield('mail-title')
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>

                            <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="100%"
                                   bgcolor="#4dbfbf">
                                <tr>
                                    <td>
                                        <br>
                                        <center>
                                            <table style="margin:0 auto;" cellspacing="0" cellpadding="0"
                                                   class="force-width-80">
                                                <tr>


                                                    <td>
                                                        <!-- ======== STEP ONE ========= -->
                                                        <!-- ==== Please use this url: https://www.filepicker.io/api/file/cdDaXwrhTd6EpvjpwqP1 in the src below in order to set the progress to one.

                                                        Then replace step two with this url: https://www.filepicker.io/api/file/MD29ZQs3RdK7mSu0VqxZ


                                                        Then replace step three with this url: https://www.filepicker.io/api/file/qnkuUNPS6TptLRIjWERA ==== -->
                                                        <img class="step-width"
                                                             src="https://www.filepicker.io/api/file/MMVdxAuqQuy7nqVEjmPV"
                                                             alt="Paso 1">
                                                    </td>


                                                    <!-- ======== STEP TWO ========= -->
                                                    <!-- ==== Please use this url: https://www.filepicker.io/api/file/QKOMsiThQcePodddaOHk in the src below in order to set the progress to two.

                                                    Then replace step three with this url: https://www.filepicker.io/api/file/qnkuUNPS6TptLRIjWERA

                                                    Then replace step one with this url: https://www.filepicker.io/api/file/MMVdxAuqQuy7nqVEjmPV ==== -->
                                                    <td>
                                                        <img class="step-width"
                                                             src="https://www.filepicker.io/api/file/QKOMsiThQcePodddaOHk"
                                                             alt="Paso 2">
                                                    </td>


                                                    <!-- ======== STEP THREE ========= -->
                                                    <!-- ==== Please use this url: https://www.filepicker.io/api/file/mepNOdHRTCMs1Jrcy2fU in the src below in order to set the progress to three.

                                                    Then replace step one with this url: https://www.filepicker.io/api/file/MMVdxAuqQuy7nqVEjmPV

                                                    Then replace step two with this url: https://www.filepicker.io/api/file/MD29ZQs3RdK7mSu0VqxZ ==== -->
                                                    <td>
                                                        <img class="step-width"
                                                             src="https://www.filepicker.io/api/file/qnkuUNPS6TptLRIjWERA"
                                                             alt="Paso 3">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="vertical-align:top; color:#187272; font-weight:bold;">
                                                        Registro
                                                    </td>
                                                    <td style="vertical-align:top; color:#187272; font-weight:bold;">
                                                        Confirmaci&oacute;n
                                                    </td>
                                                    <td style="vertical-align:top; color:#187272; font-weight:bold;">
                                                        Hecho!
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <center>
                                            <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="60%">
                                                <tr>
                                                    <td style="color:white">
                                                        <br>
                                                        <br>
                                                        @yield('mail-message')
                                                        <br>
                                                        <br>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div><!--[if mso]>
                                            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                                         xmlns:w="urn:schemas-microsoft-com:office:word" href="http://"
                                                         style="height:50px;v-text-anchor:middle;width:200px;"
                                                         arcsize="8%" stroke="f" fillcolor="#178f8f">
                                                <w:anchorlock/>
                                                <center>
                                            <![endif]-->
                                            @yield('mail-btn')
                                            <!--[if mso]>
                                            </center>
                                            </v:roundrect>
                                            <![endif]--></div>
                                        <h5 style="color:#178f8f">Si tu no has creado esta cuenta no confirmes este
                                            registro,<br> ya no recibirá información.</h5>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                            @include('layouts.partials.mail.footmail')
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>