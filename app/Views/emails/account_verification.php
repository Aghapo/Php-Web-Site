<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc(lang('Email.verification_subject')) ?></title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f6f8; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); }
        .header { background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); padding: 35px 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .content { padding: 35px 30px; line-height: 1.6; }
        .greeting { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 15px; }
        .btn-wrapper { text-align: center; margin: 30px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3); }
        .code-box { background-color: #f3f4f6; border: 2px dashed #d1d5db; border-radius: 8px; padding: 15px; text-align: center; margin: 25px 0; }
        .code-title { font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .code-value { font-size: 28px; font-weight: 700; color: #4f46e5; letter-spacing: 4px; }
        .notice { font-size: 13px; color: #6b7280; margin-top: 25px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .footer { background-color: #f9fafb; padding: 20px 30px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Başlık -->
            <div class="header">
                <h1><?= esc(lang('Email.app_name')) ?></h1>
            </div>

            <!-- İçerik -->
            <div class="content">
                <div class="greeting">
                    <?= lang('Email.greeting', ['name' => esc($name ?? 'Kullanıcı')]) ?>
                </div>

                <p><?= esc(lang('Email.verification_text')) ?></p>

                <!-- Doğrulama Butonu -->
                <div class="btn-wrapper">
                    <a href="<?= esc($verifyUrl) ?>" class="btn" target="_blank">
                        <?= esc(lang('Email.verification_btn')) ?>
                    </a>
                </div>

                <!-- Doğrulama Kodu Kutusu -->
                <?php if (!empty($verifCode)): ?>
                    <div class="code-box">
                        <div class="code-title"><?= esc(lang('Email.verification_code_text')) ?></div>
                        <div class="code-value"><?= esc($verifCode) ?></div>
                    </div>
                <?php endif; ?>

                <div class="notice">
                    <p><strong>ℹ️</strong> <?= esc(lang('Email.verification_expire')) ?></p>
                    <p style="word-break: break-all; font-size: 12px; color: #9ca3af;">
                        <?= esc($verifyUrl) ?>
                    </p>
                </div>
            </div>

            <!-- Alt Bilgi -->
            <div class="footer">
                <p><?= esc(lang('Email.footer_notice')) ?></p>
                <p>&copy; <?= date('Y') ?> <?= esc(lang('Email.app_name')) ?>. <?= esc(lang('Email.rights_reserved')) ?></p>
            </div>
        </div>
    </div>
</body>
</html>
