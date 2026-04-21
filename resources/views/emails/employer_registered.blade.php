<x-email_layout>

    <div style="margin:20px 10px;background:#ffffff;border-radius:10px;padding:30px 25px;">

        <h2 style="margin:0 0 25px;font-size:22px;font-weight:600;">
            Hi {{ $companyTitle }}!
        </h2>

        <p style="font-size:15px;line-height:1.9;margin:0 0 25px;color:#555;">
            Your hiring just got easier.
            <a href="{{ route('login') }}" 
               style="color:#1e40af;text-decoration:none;font-weight:600;">
               Start exploring talented candidates
            </a>
            and grow your team today!
        </p>

        <div style="margin-top:30px;">
            <a href="{{ route('login') }}"
               style="background:#1e40af;color:#fff;padding:14px 26px;border-radius:6px;text-decoration:none;display:inline-block;">
                Explore Candidates
            </a>
        </div>

    </div>

</x-email_layout>