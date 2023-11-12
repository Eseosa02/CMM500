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
                                                                    <p style="line-height: 140%;">We found {{ count($joblistings) }}+ jobs matching your profile and skillset.</p>
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
@foreach ($joblistings as $key => $listing)
    @if ($key <= 3)
        <div class="u-row-container" style="padding: 5px 0px 0px;background-color: transparent">
            <div class="u-row" style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                    <!--[if (mso)|(IE)]>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding: 5px 0px 0px;background-color: transparent;" align="center">
                                <table cellpadding="0" cellspacing="0" border="0" style="width:600px;">
                                    <tr style="background-color: transparent;">
                                        <![endif]-->
                                        <!--[if (mso)|(IE)]>
                                        <td align="center" width="168" style="background-color: #ffffff;width: 168px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top">
                                            <![endif]-->
                                            <div class="u-col u-col-28" style="max-width: 320px;min-width: 168px;display: table-cell;vertical-align: top;">
                                                <div style="background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                    <!--[if (!mso)&(!IE)]><!-->
                                                    <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                        <!--<![endif]-->
                                                        <table id="u_content_text_4" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;" align="left">
                                                                        <div class="v-text-align v-font-size" style="font-size: 36px; color: #ffffff; line-height: 140%; text-align: right; word-wrap: break-word;">
                                                                            <p style="line-height: 140%;"><span style="background-color: #000000; line-height: 50.4px;"> {{ $key + 1 }} </span></p>
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
                                        <td align="center" width="432" style="background-color: #f6f6f6;width: 432px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top">
                                            <![endif]-->
                                            <div class="u-col u-col-72" style="max-width: 320px;min-width: 432px;display: table-cell;vertical-align: top;">
                                                <div style="background-color: #f6f6f6;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                    <!--[if (!mso)&(!IE)]><!-->
                                                    <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                        <!--<![endif]-->
                                                        <table id="u_content_heading_3" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:6px 10px 0px;font-family:arial,helvetica,sans-serif;" align="left">
                                                                        <h1 class="v-text-align v-font-size" style="margin: 0px; color: #0254fb; line-height: 140%; text-align: left; word-wrap: break-word; font-size: 18px; font-weight: 700;">{{ Str::title($listing->jobListing->title) }}:</h1>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table id="u_content_text_16" style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    {{ route('pages.jobs.detail', ['uniqueId' => $listing->jobListing->job_reference, 'titleSlug' => $listing->jobListing->title_slug]) }}
                                                                    <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:10px 50px 10px 10px;font-family:arial,helvetica,sans-serif;" align="left">
                                                                        <div class="v-text-align v-font-size" style="font-size: 14px; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                            <p style="line-height: 140%;">{!! Str::substr($listing->jobListing->description, 0, 125) !!}</p>
                                                                            <p style="line-height: 140%;"> </p>
                                                                            <p style="line-height: 140%;"><a href="{{ route('pages.jobs.detail', ['uniqueId' => $listing->jobListing->job_reference, 'titleSlug' => $listing->jobListing->title_slug]) }}" target="_blank">Read More </a></p>
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
    @endif
@endforeach
@endsection
