<x-email_layout>

    <td style="padding:30px;color:#333;">
        <h2 style="margin-top:0;">Good Morning {{ $name }}</h2>

        <p style="font-size:15px;line-height:1.6;">
            Hope you're doing great!
        </p>

        <p style="font-size:15px;line-height:1.6;">
            New job opportunities are waiting for you today. Take a step forward in your career journey.
        </p>

        <!-- Button -->
        <div style="text-align:center;margin:30px 0;">
            <a href="{{ route('seeker.index') }}"
                style="background:#1e40af;color:#ffffff;padding:12px 25px;text-decoration:none;border-radius:6px;font-size:14px;">
                Explore Jobs
            </a>
        </div>

        <p style="font-size:14px;color:#555;">
            Best regards,<br>
            <strong>CareerCraft Team</strong>
        </p>
    </td>

</x-email_layout>
