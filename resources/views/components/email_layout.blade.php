<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:20px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0"
                style="background:#ffffff;border-radius:10px;overflow:hidden;font-family:Arial, sans-serif;">

                <!-- Header -->
                <tr>
                    <td style="background:#1e40af;color:#ffffff;padding:20px;text-align:center;">
                        <h2 style="margin:0;">Career Craft</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    {{ $slot }}
                </tr>

                
                <!-- Footer -->
                <tr>
                    <td style="background:#f1f5f9;padding:15px;text-align:center;font-size:12px;color:#777;">
                        © {{ date('Y') }} CareerCraft. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
