<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('APP_NAME') }} パスワードリセットのお知らせ</title>
    </head>
    <body>
        <div style="text-align: center; margin-left: 100px; width: 600px;">
            <p style="text-align: left;">
                {{ env('APP_NAME') }}のパスワードリセットのリクエスト受け付けました。<br>
                下記のボタンをクリックし、新しいパスワードを登録して下さい。
            </p>
            <a href="{{ $mailData['reset_link'] }}">
                <button style="background-color: #3490dc; padding: 10px; color : white; border : none;">
                    パスワードリセット
                </button>
            </a>
            <p style="text-align: left;">
                ※このリンクの有効期限は60分です。 <br>
                ※このメールは送信専用です。ご返信いただけませんので、予めご了承ください。 <br>
                ※お問い合わせの際は、サイト内お問い合わせフォームよりご連絡をお願いします。 <br>
            </p>
        </div>
    </body>
</html>