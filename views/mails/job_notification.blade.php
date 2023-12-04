@extends('layouts.mails.app')
@section('content')
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row" style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding: 0px;background-color: transparent;" align="center">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:600px;">
                                <tr style="background-color: transparent;">
                                    <![endif]-->
                                    <!--[if (mso)|(IE)]>
                                    <td align="center" width="600" style="background-color: #f5f7ff;width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top">
                                        <![endif]-->
                                        <div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                            <div style="background-color: #f5f7ff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                <!--[if (!mso)&(!IE)]><!-->
                                                <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                    <!--<![endif]-->
                                                    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:30px;font-family:arial,helvetica,sans-serif;" align="left">
                                                                    <div class="v-text-align v-font-size" style="font-size: 14px; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                        <h3>Hello {{ $user->name }},</h3>
                                                                        <p style="line-height: 140%;">
                                                                            We have a new notification on a job you applied for recently.
                                                                        </p>
                                                                        <p style="line-height: 140%;">
                                                                            Your application to {{ $jobApplication->jobListing->employer->name }} for the role of a {{ Str::title($jobApplication->jobListing->title) }} has been {{ $jobApplication->status === 'under-review' ? 'moved to' : '' }} {{ $jobApplication->status }}.
                                                                        </p>
                                                                        <p style="line-height: 140%;">
                                                                            You can access your dashboard to see other notifications
                                                                        </p>
                                                                        <center>
                                                                            <a href="{{ route('login') }}">
                                                                                <button style="padding: 10px 15px;border: 1px solid green;cursor: pointer;background: green;color: #fff;">Dashboard</button>
                                                                            </a>
                                                                        </center>
                                                                        <p style="line-height: 140%;">
                                                                            Regards,<br>
                                                                            <i>{{ env('APP_NAME') }} Team</i>
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if (!mso)&(!IE)]><!-->
                                                </div>
                                                <!--<![endif]-->
                                            </div>
                                        </div>
                                        <!--[if (mso)|(IE)]>
                                    </td>
                                    <![endif]-->
                                    <!--[if (mso)|(IE)]>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <![endif]-->
            </div>
        </div>
    </div>
@endsection
