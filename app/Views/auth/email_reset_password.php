<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - E-Layanan Akademik</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7f9fc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f9fc; padding: 40px 20px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 500px; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                
                <!-- HEADER -->
                <tr>
                    <td style="padding: 30px 40px 20px; text-align: center;">
                        <h1 style="color: #10367D; font-size: 16px; font-weight: 700; margin: 0; letter-spacing: 1px; text-transform: uppercase;">E-Layanan Akademik</h1>
                        <p style="color: #8f9bb3; font-size: 11px; margin: 4px 0 0 0; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Dinas Kominfo Kota Tangerang</p>
                        
                        <!-- Divider -->
                        <div style="height: 2px; width: 40px; background-color: #B58E4A; margin: 20px auto 0;"></div>
                    </td>
                </tr>

                <!-- BODY -->
                <tr>
                    <td style="padding: 10px 40px 30px;">
                        
                        <p style="font-size: 16px; font-weight: 600; color: #1a202c; margin: 0 0 20px 0; text-align: center;">Permintaan Reset Password</p>
                        
                        <p style="font-size: 14px; color: #4a5568; line-height: 1.6; margin: 0 0 16px 0;">
                            Yth. <strong><?= esc($nama) ?></strong>,
                        </p>

                        <p style="font-size: 14px; color: #4a5568; line-height: 1.6; margin: 0 0 30px 0;">
                            Kami menerima permintaan untuk melakukan reset password pada akun E-Layanan Akademik Anda. Silakan klik tombol di bawah ini untuk membuat password baru.
                        </p>

                        <!-- CTA BUTTON -->
                        <div style="text-align: center; margin-bottom: 30px;">
                            <a href="<?= esc($resetLink) ?>" 
                               style="display: inline-block; padding: 12px 30px; background-color: #10367D; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; transition: background-color 0.2s;">
                                Reset Password
                            </a>
                        </div>

                        <!-- Info & Warning -->
                        <div style="border-top: 1px solid #edf2f7; padding-top: 20px;">
                            <p style="font-size: 13px; color: #718096; margin: 0 0 8px 0; line-height: 1.5;">
                                <span style="color: #10367D; font-weight: 600;">Penting:</span> Tautan ini hanya berlaku selama <strong>1 jam</strong> dan hanya dapat digunakan satu kali.
                            </p>
                            <p style="font-size: 13px; color: #718096; margin: 0; line-height: 1.5;">
                                Jika Anda merasa tidak pernah meminta reset password, Anda dapat mengabaikan email ini dengan aman.
                            </p>
                        </div>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="padding: 20px 40px; background-color: #f8fafc; text-align: center; border-top: 1px solid #edf2f7;">
                        <p style="font-size: 11px; color: #a0aec0; margin: 0; line-height: 1.5;">
                            Ini adalah email otomatis, mohon tidak membalas ke alamat email ini.<br>
                            &copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Tangerang.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
