<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Document</title>
<style>
        *{
            margin:0;
            padding:0;
            box-sizing: border-box
        }
    </style> 
</head>
<body style="background-color:#181623; color:#ffffff;height: 100vh; width: 100%">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="height: 100vh">
    <tr>
      <td align="center" valign="top" style="padding-top: 30px">
        <table
          cellpadding="0"
          cellspacing="0"
          border="0"
          style="color: #fff"
        >
          <tr>
            <td style="padding:0 30px">
              <div>

                <div style="text-align: center; margin-bottom: 50px">                
                  <img src="{{asset('images/logo.png')}}"/>

                </div>
                <div>
                  <h2 style="margin-bottom: 20px">{{$headerText}}</h2>
                  <p style="margin-bottom: 20px">
                    Hi {{$user}},                  </p>
                    <p style="margin-bottom: 20px">
                       {{$text}}
                    </p>
                   <a href='{{$url}}' style="
                   padding: 8px 12px;
                   background-color: #e31221;
                   border: none;
                   color:#fff;
                   border-radius: 5px;
                   text-decoration:none;
                 "
                  > 
                      {{$buttonText}}
                    </a>
                  <p style="margin-top: 30px">
                    If clicking doesn't work, you can try copying and pasting it to your browser:
                  </p>
                  <p style="margin-top: 25px; color:#DDCCAA">
                    {{$url}}
                  </p>
                  <p style="margin-top: 25px; text-decoration:none; color:#fff">If you have any problems, please contact us: support@moviequotes.ge</p>
                  <p style="margin-top: 25px">MovieQuotes crew</p>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
