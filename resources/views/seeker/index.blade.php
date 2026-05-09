<x-seeker_layout>
    @php
        $userName =
            DB::table('tbl_seeker_profile')->where('login_id', session('login_id'))->value('seeker_name') ?? 'User';
    @endphp

    {{-- Search Section --}}
    <div class="mb-4">
        <form action="#" method="GET" class="d-flex justify-content-center flex-wrap gap-3">
            <div class="input-group shadow-sm"
                style="max-width: 1000px; width:100%; border-radius: 8px; overflow: hidden;">

                {{-- Keyword Input --}}
                <span class="input-group-text bg-white border-0 px-3">
                    <i class="bi bi-search fs-5 text-muted"></i>
                </span>
                <input type="text" name="q" class="form-control border-0 fs-5"
                    placeholder="Search for jobs, companies, or skills..."
                    style="padding: 18px 20px; height:60px; min-width:350px; flex:2;">

                {{-- Location Input --}}
                <span class="input-group-text bg-white border-0 px-3">
                    <i class="bi bi-geo-alt-fill fs-5 text-muted"></i>
                </span>
                <input type="text" name="location" class="form-control border-0 fs-5" placeholder="City or Location"
                    style="padding: 18px 20px; height:60px; min-width:200px; flex:1;">

                {{-- Search Button --}}
                <button type="submit" class="btn btn-blue-800 px-5 fs-5" style="border-radius: 0; height:60px;">
                    Search
                </button>
            </div>
        </form>
    </div>

    {{-- Welcome Section --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">Welcome back, {{ auth()->user()->name ?? 'Job Seeker' }}</h2>
        <p class="text-muted">Here’s a quick overview of your activity.</p>
    </div>

    {{-- Quick Stats --}}
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Applications</h6>
                    <p class="display-6 text-primary">12</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Saved Jobs</h6>
                    <p class="display-6 text-success">5</p>
                    <a href="#" class="btn btn-outline-success btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Profile Strength</h6>
                    <p class="display-6 text-warning">80%</p>
                    <a href="#" class="btn btn-outline-warning btn-sm">Complete</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest / Recommended Jobs --}}
    <div class="mt-5">
        <h4 class="fw-bold mb-3">Recommended Jobs for You</h4>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 position-relative">
                        <div class="card-body">
                            {{-- Save Icon (Toggle) --}}
                            <a href="javascript:void(0)" class="save-job position-absolute top-0 end-0 m-3 text-muted"
                                data-saved="false">
                                <i class="bi bi-bookmark fs-5"></i>
                            </a>

                            <h6 class="fw-bold">Frontend Developer</h6>
                            <p class="text-muted mb-1">TechCorp Pvt Ltd</p>
                            <p class="text-muted">Bangalore • 2-4 yrs</p>

                            <a href="#" class="btn btn-sm btn-blue-800">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 position-relative">
                        <div class="card-body">
                            {{-- Save Icon (Toggle) --}}
                            <a href="javascript:void(0)" class="save-job position-absolute top-0 end-0 m-3 text-muted"
                                data-saved="false">
                                <i class="bi bi-bookmark fs-5"></i>
                            </a>

                            <h6 class="fw-bold">Frontend Developer</h6>
                            <p class="text-muted mb-1">TechCorp Pvt Ltd</p>
                            <p class="text-muted">Bangalore • 2-4 yrs</p>

                            <a href="#" class="btn btn-sm btn-blue-800">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chatbot Floating Button --}}
    <div id="chatbotToggle">
        <i class="bi bi-chat-dots-fill"></i>
    </div>

    {{-- Chatbot Box --}}
    <div id="chatbotBox">
        <div class="chat-header">

            <div class="d-flex align-items-center">

                <div class="robot-circle me-2">
                    <i class="bi bi-robot"></i>
                </div>

                <div>
                    <strong>Portal Assistant</strong>
                    <div class="small text-light">Online</div>
                </div>

            </div>

            <div class="chat-actions">

                <button id="clearChat" class="clear-chat-btn">
                    <i class="bi bi-trash3"></i>
                </button>

                <button id="closeChat" class="close-chat-btn">
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>

        </div>

        <div class="chat-messages" id="messages">

            <div class="bot-message">
                Hello 👋 <br>
                How can I help you today?
            </div>

        </div>

        <div class="chat-input">

            <input type="text" id="message" placeholder="Type your message...">

            <button id="sendBtn">
                <i class="bi bi-send-fill"></i>
            </button>

        </div>

    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                //This waits until the HTML page is fully loaded before running the code.
                //Prevents errors if elements aren’t ready yet.

                // Check if already shown in this session
                if (sessionStorage.getItem("greetingShown")) {
                    return; // Don't show again
                }

                // ✅ Mark as shown
                sessionStorage.setItem("greetingShown", "true");

                let hour = new Date().getHours(); //Gets current time (0–23 format).

                let greeting = "";
                if (hour < 12) {
                    greeting = "Good Morning";
                } else if (hour < 17) {
                    greeting = "Good Afternoon";
                } else {
                    greeting = "Good Evening";
                }

                const Toast = Swal.mixin({ //mixin() creates a reusable toast configuration.
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });

                Toast.fire({
                    title: greeting + ", {{ $userName ?? 'User' }}!"
                });

            });


            /*
            |--------------------------------------------------------------------------
            | Load Saved Chats
            |--------------------------------------------------------------------------
            */

            let savedChats = localStorage.getItem('careerCraftChats');

            if (savedChats) {

                $('#messages').html(savedChats);
            }


            /*
            |--------------------------------------------------------------------------
            | Save Chats Function
            |--------------------------------------------------------------------------
            */

            function saveChats() {

                localStorage.setItem(
                    'careerCraftChats',
                    $('#messages').html()
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Open Chatbot
            |--------------------------------------------------------------------------
            */

            $('#chatbotToggle').click(function() {

                if ($('#chatbotBox').is(':visible')) {

                    $('#chatbotBox').hide();

                } else {

                    $('#chatbotBox').css('display', 'flex');
                }

            });


            /*
            |--------------------------------------------------------------------------
            | Close Chatbot
            |--------------------------------------------------------------------------
            */

            $(document).on('click', '#closeChat', function() {

                $('#chatbotBox').hide();

            });


            /*
            |--------------------------------------------------------------------------
            | Send Message
            |--------------------------------------------------------------------------
            */

            $('#sendBtn').click(function() {

                let message = $('#message').val();

                if (message.trim() == '') return;


                /*
                |--------------------------------------------------------------------------
                | Append User Message
                |--------------------------------------------------------------------------
                */

                $('#messages').append(`
                    <div class="user-message">
                        ${message}
                    </div>
                `);

                saveChats();

                $('#message').val('');


                /*
                |--------------------------------------------------------------------------
                | AJAX Request
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url: "{{ route('seeker.chatbot.send') }}",

                    type: 'POST',

                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        message: message
                    },

                    success: function(response) {

                        /*
                        |--------------------------------------------------------------------------
                        | Append Bot Message
                        |--------------------------------------------------------------------------
                        */

                        $('#messages').append(`
                    <div class="bot-message">
                        ${response.reply}
                    </div>
                `);

                        saveChats();

                        $('#messages').scrollTop(
                            $('#messages')[0].scrollHeight
                        );
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);
                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Send Message On Enter
            |--------------------------------------------------------------------------
            */

            $('#message').keypress(function(e) {

                if (e.which == 13) {

                    $('#sendBtn').click();
                }

            });


            /*
            |--------------------------------------------------------------------------
            | Clear Chat
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '#clearChat', function() {

                localStorage.removeItem('careerCraftChats');

                $('#messages').html(`
                    <div class="bot-message">
                        Hello <br>
                        How can I help you today?
                    </div>
                `);

            });
        </script>
    @endpush
</x-seeker_layout>
