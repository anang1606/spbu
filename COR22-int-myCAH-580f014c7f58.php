<?php

$env = file_get_contents(__DIR__ . "/.env");
$env = explode("\n", $env);

$is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
// if($is_page_refreshed ) {
    $curl = curl_init();
    foreach ($env as $line) {
        $parts = explode("=", $line);
        if (count($parts) == 2) {
            $key = $parts[0];
            $value = $parts[1];
            $data_env[$key] = $value;
        }
    }

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://billing.aturuangpos.com/api/authorized',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('url' => $actual_link),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . base64_encode(base64_encode($data_env['APP_UNIQ_KEY']) . '.' . $data_env['APP_UNIQ_KEY'] . '.' . base64_encode(rand() * rand() * 100))
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    if($response){
        if(json_decode($response)->status === 'Failed'){
            $contents = '<html>
                <head></head>
                <body></body>
            </html>';
            $data = json_decode($response)->data;

            echo inject_style($contents);
            echo inject_body($contents,$data->logo,$data->url_payments);

            exit();
        }else if(json_decode($response)->status === 'Restricted'){
            $contents = '<html>
                <head></head>
                <body></body>
            </html>';

            echo inject_style_restirected($contents);
            echo inject_body_restirected($contents);
            exit();
        }
    }
// }

function inject_body_restirected($contents){
    $contents_body = '<div class="container">
      <div class="chain left"></div>
      <div class="chain right"></div>
      <div class="cog left">
        <svg width="150px" height="150px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="cog" fill-rule="nonzero">
                <path d="M36.601563,23.199219 C36.699219,22.5 36.800781,21.800781 36.800781,21 C36.800781,20.199219 36.699219,19.5 36.601563,18.800781 L41.101563,15.601563 C41.5,15.300781 41.699219,14.699219 41.398438,14.199219 L37,6.800781 C36.699219,6.300781 36.199219,6.101563 35.699219,6.398438 L30.699219,8.699219 C29.5,7.800781 28.300781,7.101563 26.898438,6.5 L26.398438,1 C26.300781,0.5 25.898438,0.101563 25.398438,0.101563 L16.800781,0.101563 C16.300781,0.101563 15.800781,0.5 15.800781,1 L15.300781,6.5 C13.898438,7.101563 12.601563,7.800781 11.5,8.699219 L6.5,6.398438 C6,6.199219 5.398438,6.398438 5.199219,6.800781 L0.898438,14.199219 C0.601563,14.699219 0.800781,15.300781 1.199219,15.601563 L5.699219,18.800781 C5.601563,19.5 5.5,20.199219 5.5,21 C5.5,21.800781 5.601563,22.5 5.699219,23.199219 L1,26.398438 C0.601563,26.699219 0.398438,27.300781 0.699219,27.800781 L5,35.199219 C5.300781,35.699219 5.800781,35.898438 6.300781,35.601563 L11.300781,33.300781 C12.5,34.199219 13.699219,34.898438 15.101563,35.5 L15.601563,41 C15.699219,41.5 16.101563,41.898438 16.601563,41.898438 L25.199219,41.898438 C25.699219,41.898438 26.199219,41.5 26.199219,41 L26.699219,35.5 C28.101563,34.898438 29.398438,34.199219 30.5,33.300781 L35.5,35.601563 C36,35.800781 36.601563,35.601563 36.800781,35.199219 L41.101563,27.800781 C41.398438,27.300781 41.199219,26.699219 40.800781,26.398438 L36.601563,23.199219 Z M21,31 C15.5,31 11,26.5 11,21 C11,15.5 15.5,11 21,11 C26.5,11 31,15.5 31,21 C31,26.5 26.5,31 21,31 Z" id="Shape" fill="#C7A005" class="cog-outer"></path>
                <path d="M21,9 C14.398438,9 9,14.398438 9,21 C9,27.601563 14.398438,33 21,33 C27.601563,33 33,27.601563 33,21 C33,14.398438 27.601563,9 21,9 Z M21,26 C18.199219,26 16,23.800781 16,21 C16,18.199219 18.199219,16 21,16 C23.800781,16 26,18.199219 26,21 C26,23.800781 23.800781,26 21,26 Z" id="Shape" fill="#F1C40F" class="cog-inner"></path>
            </g>
        </g>
    </svg>
      </div>
      <div class="cog right">
        <svg width="150px" height="150px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="cog" fill-rule="nonzero">
                <path d="M36.601563,23.199219 C36.699219,22.5 36.800781,21.800781 36.800781,21 C36.800781,20.199219 36.699219,19.5 36.601563,18.800781 L41.101563,15.601563 C41.5,15.300781 41.699219,14.699219 41.398438,14.199219 L37,6.800781 C36.699219,6.300781 36.199219,6.101563 35.699219,6.398438 L30.699219,8.699219 C29.5,7.800781 28.300781,7.101563 26.898438,6.5 L26.398438,1 C26.300781,0.5 25.898438,0.101563 25.398438,0.101563 L16.800781,0.101563 C16.300781,0.101563 15.800781,0.5 15.800781,1 L15.300781,6.5 C13.898438,7.101563 12.601563,7.800781 11.5,8.699219 L6.5,6.398438 C6,6.199219 5.398438,6.398438 5.199219,6.800781 L0.898438,14.199219 C0.601563,14.699219 0.800781,15.300781 1.199219,15.601563 L5.699219,18.800781 C5.601563,19.5 5.5,20.199219 5.5,21 C5.5,21.800781 5.601563,22.5 5.699219,23.199219 L1,26.398438 C0.601563,26.699219 0.398438,27.300781 0.699219,27.800781 L5,35.199219 C5.300781,35.699219 5.800781,35.898438 6.300781,35.601563 L11.300781,33.300781 C12.5,34.199219 13.699219,34.898438 15.101563,35.5 L15.601563,41 C15.699219,41.5 16.101563,41.898438 16.601563,41.898438 L25.199219,41.898438 C25.699219,41.898438 26.199219,41.5 26.199219,41 L26.699219,35.5 C28.101563,34.898438 29.398438,34.199219 30.5,33.300781 L35.5,35.601563 C36,35.800781 36.601563,35.601563 36.800781,35.199219 L41.101563,27.800781 C41.398438,27.300781 41.199219,26.699219 40.800781,26.398438 L36.601563,23.199219 Z M21,31 C15.5,31 11,26.5 11,21 C11,15.5 15.5,11 21,11 C26.5,11 31,15.5 31,21 C31,26.5 26.5,31 21,31 Z" id="Shape" fill="#927d0a" class="cog-outer"></path>
                <path d="M21,9 C14.398438,9 9,14.398438 9,21 C9,27.601563 14.398438,33 21,33 C27.601563,33 33,27.601563 33,21 C33,14.398438 27.601563,9 21,9 Z M21,26 C18.199219,26 16,23.800781 16,21 C16,18.199219 18.199219,16 21,16 C23.800781,16 26,18.199219 26,21 C26,23.800781 23.800781,26 21,26 Z" id="Shape" fill="#F1C40F" class="cog-inner"></path>
            </g>
        </g>
    </svg>
      </div>
      <div class="steam left"></div>
      <div class="steam right"></div>
      <div class="message animated bounceInDown">
        <div class="rivet top-left"></div>
        <div class="rivet top-right"></div>
        <div class="rivet bottom-left"></div>
        <div class="rivet bottom-right"></div>
        <div class="message-inner">
        <h1 class="message-title">Access <br />Forbidden</h1>
        <p class="message-subtitle">Error code 403</p>
          </div>
      </div>
    </div>';
    return str_replace('</body>', $contents_body . '</body>', $contents);
}

function inject_style_restirected($contents){
    $style = '<style type="text/css">@import url("https://fonts.googleapis.com/css2?family=Sancreek&display=swap");
        body{
            margin:0;
            padding:0;
        }
         *,
            *::before,
            *::after {
              box-sizing: border-box;
            }
            body {
              font-family: "Sancreek", cursive;
            }
            .container {
              position: relative;
              height: 100vh;
              overflow: hidden;
              background: #282820;
              z-index: -1;
            }
            .message {
              text-align: center;
              position: absolute;
              left: 0;
              right: 0;
              z-index: 1;
              top: 150px;
              width: 432px;
              height: 324px;
              margin: 0 auto;
              border: 20px solid #b1811d;
              background: #b1811d;
              border-radius: 20px;
              box-shadow: 0px 0px 0px 4px #471f05;
              animation-delay: 1s;
              animation-duration: 1.3s;
            }
            .message::before,
            .message::after {
              content: "";
              position: absolute;
              bottom: 107%;
              width: 50px;
              height: 300px;
              background: url(https://i.postimg.cc/0QbqNZYv/chain-4.png) repeat-y center;
              z-index: -10;
            }
            .message::before {
              left: 20px;
            }
            .message::after {
              right: 20px;
            }
            .message-inner {
              padding: 40px;
              border-radius: 20px;
              position: absolute;
              top: 2%;
              right: 2%;
              bottom: 2%;
              left: 2%;
              color: #291b03;
              background: #825301;
            }
            .message-title {
              font-size: 4em;
              margin: 0;
            }
            .message-subtitle {
              font-size: 2em;
              margin: 0;
            }
            .chain {
              position: absolute;
              top: 0;
              height: 200%;
              width: 50px;
              background: url(https://i.postimg.cc/0QbqNZYv/chain-4.png) repeat-y center;
              animation: chain 1.8s ease-in-out;
            }
            .chain.left {
              left: 0;
            }
            .chain.right {
              right: 0;
            }
            .cog {
              position: absolute;
              bottom: -50px;
            }
            .cog.left {
              left: -50px;
              animation: cog-spin-left 1.8s ease-in-out;
            }
            .cog.right {
              right: -50px;
              animation: cog-spin-right 1.8s ease-in-out;
            }
            .cog-outer {
              fill: #955112;
            }
            .cog-inner {
              fill: #633d03;
            }
            .rivet {
              position: absolute;
              background-color: #8f6002;
              width: 3%;
              border-radius: 100px;
              padding-bottom: 3%;
            }
            .rivet.top-left {
              top: -7px;
              left: -7px;
            }
            .rivet.top-right {
              top: -7px;
              right: -7px;
            }
            .rivet.bottom-left {
              bottom: -7px;
              left: -7px;
            }
            .rivet.bottom-right {
              bottom: -7px;
              right: -7px;
            }
            @keyframes cog-spin-left {
              from {
                transform: rotate(0deg);
              }
              to {
                transform: rotate(360deg);
              }
            }
            @keyframes cog-spin-right {
              from {
                transform: rotate(0deg);
              }
              to {
                transform: rotate(-360deg);
              }
            }
            @keyframes chain {
              from {
                top: 0;
              }
              to {
                top: -100%;
              }
            }

    </style>';
    return str_replace('</head>', $style . '<title>ERROR: 403</title></head>', $contents);
}
function inject_body($contents,$logo,$url_payments){
    $contents_body = '<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #F6F5FF;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <div class="spacer_block"
                                                            style="height:20px;line-height:20px;font-size:1px;"> </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #333; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="50%">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="image_block block-2" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad"
                                                                    style="padding-left:10px;width:100%;padding-right:0px;padding-top:7px;padding-bottom:5px;">
                                                                    <div align="left" class="alignment"
                                                                        style="line-height:10px"><img alt="Image"
                                                                            src="http://billing.aturuangpos.com/images/atur-uang.svg"
                                                                            style="display: block; height: auto; border: 0; width: 180PX; max-width: 100%;"
                                                                            title="Image" width="180" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <div class="spacer_block"
                                                            style="height:20px;line-height:20px;font-size:1px;"> </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="image_block block-1" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad"
                                                                    style="width:100%;padding-right:0px;padding-left:0px;">
                                                                    <div align="center" class="alignment"
                                                                        style="line-height:10px"><img alt="Image"
                                                                            class="big" src="http://billing.aturuangpos.com/images/Top.png"
                                                                            style="display: block; height: auto; border: 0; width: 650px; max-width: 100%;"
                                                                            title="Image" width="650" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 30px; padding-right: 30px; vertical-align: top; padding-top: 25px; padding-bottom: 10px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block block-1" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad"
                                                                    style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:10px;">
                                                                    <div style="font-family: sans-serif">
                                                                        <div class=""
                                                                            style="font-size: 16px; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 19.2px; color: #B1AED1; line-height: 1.2;">
                                                                            <p
                                                                                style="margin: 0; font-size: 16px; text-align: center; mso-line-height-alt: 19.2px;">
                                                                                <span style="font-size:20px;">WE MISS
                                                                                    YOU :(</span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block block-2" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad"
                                                                    style="padding-bottom:5px;padding-left:5px;padding-right:5px;">
                                                                    <div
                                                                        style="font-family: Tahoma, Verdana, sans-serif">
                                                                        <div class=""
                                                                            style="font-size: 12px; font-family: "Roboto", Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #454562; line-height: 1.2;">
                                                                            <p
                                                                                style="margin: 0; text-align: center; font-size: 12px; mso-line-height-alt: 14.399999999999999px;">
                                                                                <span style="font-size:38px;">We haven`t received your
                                                                                payment for this software</span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 30px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="image_block block-1" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad"
                                                                    style="width:100%;padding-right:0px;padding-left:0px;">
                                                                    <div align="center" class="alignment"
                                                                        style="line-height:10px"><img alt="I`m an image"
                                                                            class="big"
                                                                            src="http://billing.aturuangpos.com/images/Sad_illustration.png"
                                                                            style="display: block; height: auto; border: 0; width: 650px; max-width: 100%;"
                                                                            title="I`m an image" width="650" /></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            class="text_block block-2" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad"
                                                                    style="padding-bottom:10px;padding-left:40px;padding-right:40px;padding-top:10px;">
                                                                    <div style="font-family: sans-serif">
                                                                        <div class=""
                                                                            style="font-size: 14px; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 21px; color: #555555; line-height: 1.5;">
                                                                            <p
                                                                                style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 21px;">
                                                                                We hope this message finds you well. We wanted to remind you that there seems to be an outstanding invoice for your application. We understand that these things can sometimes slip our minds, but we want to ensure that your experience with our application remains seamless.</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="button_block block-3" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad">
                                                                    <div align="center" class="alignment">
                                                                        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:42px;width:269px;v-text-anchor:middle;" arcsize="120%" stroke="false" fillcolor="#C059FF"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:16px"><![endif]--><a
                                                                            href="'.$url_payments.'"
                                                                            style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#C059FF;border-radius:50px;width:auto;border-top:0px solid transparent;font-weight:undefined;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;"
                                                                            target="_blank"><span
                                                                                style="padding-left:50px;padding-right:50px;font-size:16px;display:inline-block;letter-spacing:normal;"><span
                                                                                    style="word-break: break-word; line-height: 32px;"><strong>PAY NOW</strong></span></span></a>
                                                                        <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7"
                            role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <div class="spacer_block"
                                                            style="height:20px;line-height:20px;font-size:1px;"> </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-8"
                            role="presentation"
                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;"
                            width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0"
                                            class="row-content stack" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;"
                                            width="650">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 20px; padding-right: 20px; vertical-align: top; padding-top: 15px; padding-bottom: 15px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                        width="100%">
                                                        <table border="0" cellpadding="10" cellspacing="0"
                                                            class="text_block block-1" role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="pad">
                                                                    <div style="font-family: sans-serif">
                                                                        <div class=""
                                                                            style="font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #6B6B6B; line-height: 1.2;">
                                                                            <p
                                                                                style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;">
                                                                                All rights reserved<br /><span
                                                                                    style="font-size:14px;color:#c059ff;">Cidigi Inovasi</span>
                                                                            </p>
                                    </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';
    return str_replace('</body>', $contents_body . '</body>', $contents);
}

function inject_style($contents){
    $styles = '<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
        <!--[if !mso]><!-->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
        <!--<![endif]-->
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 0;
            }

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: inherit !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
            }

            p {
                line-height: inherit
            }

            .desktop_hide,
            .desktop_hide table {
                mso-hide: all;
                display: none;
                max-height: 0px;
                overflow: hidden;
            }

            @media (max-width:670px) {

                .desktop_hide table.icons-inner,
                .social_block.desktop_hide .social-table {
                    display: inline-block !important;
                }

                .icons-inner {
                    text-align: center;
                }

                .icons-inner td {
                    margin: 0 auto;
                }

                .image_block img.big,
                .row-content {
                    width: 100% !important;
                }

                .mobile_hide {
                    display: none;
                }

                .stack .column {
                    width: 100%;
                    display: block;
                }

                .mobile_hide {
                    min-height: 0;
                    max-height: 0;
                    max-width: 0;
                    overflow: hidden;
                    font-size: 0px;
                }

                .desktop_hide,
                .desktop_hide table {
                    display: table !important;
                    max-height: none !important;
                }
            }
        </style>';
    return str_replace('</head>', $styles . '<title>Payment Required</title></head></head>', $contents);
}
