<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | JAYA TIBAR GROUP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #2b2b2b;
        }
        .sidebar {
            background-color: #d64541;
            color: white;
            height: 100vh;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            font-weight: 500;
        }
        .sidebar a.active {
            background-color: #c0392b;
            border-radius: 8px;
            padding-left: 15px;
        }
        .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        .content {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            margin: 30px;
            min-height: 80vh;
        }
        .emoji, .stars {
            font-size: 2rem;
            cursor: pointer;
        }
        .emoji.selected, .stars i.selected {
            color: #d64541;
        }
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-2 sidebar position-relative">
            <h5 class="fw-bold mb-4">JAYA TIBAR GROUP</h5>
            <a href="#" class="">🏠 Home Page</a>
            <a href="#" class="active">💬 Feedback</a>

            <a href="{{ route('logout') }}" 
               class="logout text-white d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </div>

        {{-- Main Content --}}
        <div class="col-10">
            <div class="bg-danger text-white d-flex justify-content-between align-items-center px-4 py-3">
                <h5 class="m-0">Feedback</h5>
                <small>{{ now()->format('l, d F Y') }}</small>
            </div>

            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('feedback.store') }}" id="feedbackForm">
                    @csrf

                    <h6 class="mb-2">How would you describe your mood after using our website?</h6>
                    <div class="d-flex gap-3 mb-4">
                        <span class="emoji" data-value="1">😞</span>
                        <span class="emoji" data-value="2">😐</span>
                        <span class="emoji" data-value="3">😊</span>
                    </div>
                    <input type="hidden" name="mood" id="mood">

                    <h6 class="mb-2">How would you rate the quality of our website?</h6>
                    <div class="stars mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating">

                    <h6>Your Feedback</h6>
                    <textarea class="form-control mb-4" name="message" rows="4" placeholder="Type your feedback..."></textarea>

                    <button type="submit" class="btn btn-danger px-4">Send Feedback</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap Icons & JS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script>
    // Emoji selector
    document.querySelectorAll('.emoji').forEach(emoji => {
        emoji.addEventListener('click', function() {
            document.querySelectorAll('.emoji').forEach(e => e.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('mood').value = this.dataset.value;
        });
    });

    // Star rating selector
    document.querySelectorAll('.stars i').forEach(star => {
        star.addEventListener('click', function() {
            const value = this.dataset.value;
            document.getElementById('rating').value = value;
            document.querySelectorAll('.stars i').forEach(s => {
                s.classList.remove('selected');
                s.classList.replace('bi-star-fill', 'bi-star');
            });
            for (let i = 1; i <= value; i++) {
                const el = document.querySelector(`.stars i[data-value='${i}']`);
                el.classList.add('selected');
                el.classList.replace('bi-star', 'bi-star-fill');
            }
        });
    });
</script>
</body>
</html>
