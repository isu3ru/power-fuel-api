@extends('layouts.email')

@section('content')
    <table style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
                <td class="v-container-padding-padding"
                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Open Sans',sans-serif;"
                    align="left">
                    <div class="v-text-align v-line-height"
                        style="color: #556ee6; line-height: 140%; text-align: left; word-wrap: break-word;">
                        <p style="font-size: 14px; line-height: 140%; text-align: center;">
                            <span style="font-size: 38px; line-height: 53.2px;">
                                <strong>
                                    <span style="line-height: 53.2px; font-size: 38px;">Reset Password</span>
                                </strong>
                            </span>
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
                <td class="v-container-padding-padding"
                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Open Sans',sans-serif;"
                    align="left">
                    <div class="v-text-align v-line-height"
                        style="line-height: 140%; text-align: left; word-wrap: break-word;">
                        <p style="font-size: 14px; line-height: 140%; text-align: center;">
                            Click below link to reset your password. You will be redirected to the login page afterwards.
                        </p>
                        <p style="font-size: 14px; line-height: 140%; text-align: center;">
                            If you did not request a password reset, please ignore this email.
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table id="u_content_button_1" style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0"
        cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
                <td class="v-container-padding-padding"
                    style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Open Sans',sans-serif;"
                    align="left">
                    <div class="v-text-align" align="center">
                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; 
                            border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;font-family:'Open Sans',sans-serif;">
                            <tr><td class="v-text-align" style="font-family:'Open Sans',sans-serif;" align="center">
                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" 
                                style="height:51px; v-text-anchor:middle; width:120px;" arcsize="8%" stroke="f" fillcolor="#556ee6">
                                <w:anchorlock/><center style="color:#FFFFFF;font-family:'Open Sans',sans-serif;"><![endif]-->
                        <a href="{{ route('password.reset', [$token, 'email' => $user->email]) }}" target="_blank" class="v-size-width"
                            style="box-sizing: border-box;display: inline-block;font-family:'Open Sans',sans-serif;text-decoration: none;
                            -webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #556ee6; border-radius: 4px;
                            -webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; 
                            word-break: break-word; word-wrap:break-word; mso-border-alt: none;">
                            <span class="v-line-height" style="display:block;padding:15px;line-height:120%;">
                                <span style="font-size: 18px; line-height: 21.6px;">
                                    <strong>
                                        <span style="line-height: 21.6px; font-size: 18px;">Click Here</span>
                                    </strong>
                                </span>
                            </span>
                        </a>
                        <!--[if mso]></center></v:roundrect></td></tr></table><![endif]-->
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
