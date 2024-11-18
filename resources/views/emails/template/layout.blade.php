<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
body{
    background: #f7fafc !important;
}
</style>
</head>

<body style="max-width: 600px; margin: 0px auto;">
@include("emails.template.partials.header")
<main>
@yield("content")
</main>
@include('emails.template.partials.footer')
</body>
</html>
