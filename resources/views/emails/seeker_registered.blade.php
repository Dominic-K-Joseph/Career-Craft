<x-email_layout>

    <div style="margin:20px 10px;background:#ffffff;border-radius:10px;padding:30px 25px;">

        <h2 style="margin:0 0 25px;font-size:22px;font-weight:600;">
            Hi {{ $seekerName }}!
        </h2>

        <p style="font-size:15px;line-height:1.9;margin:0 0 25px;color:#555;">
            Your job search just got smarter.
            <a href="{{ route('login') }}" 
               style="color:#1e40af;text-decoration:none;font-weight:600;">
               Start exploring opportunities now
            </a> 
            and kickstart your career!
        </p>

        <div style="margin-top:30px;">
            <a href="{{ route('login') }}"
               style="background:#1e40af;color:#fff;padding:14px 26px;border-radius:6px;text-decoration:none;display:inline-block;">
                Explore Jobs
            </a>
        </div>

    </div>

</x-email_layout>