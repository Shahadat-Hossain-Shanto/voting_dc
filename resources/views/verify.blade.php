<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Voter Verification</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" class="img-circle elevation-2" href="{!! asset('dist/img/logo.png') !!}" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (optional) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #00608a, #2f0042, #490000);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .card-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .form-label {
            font-weight: 600;
        }

        .btn {
            border-radius: 8px;
        }

        .alert {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Flash Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1 class="text-center text-white mb-4">Dhaka College Alumni Association HSC 96</h1>
                <!-- Voting Instructions -->
                <div class="alert alert-info shadow-sm mb-4">
                    <h5 class="fw-bold">Voting Instructions</h5>
                    <ul class="mb-0 ps-3">
                        <li>To verify your identity, please select one of the following options based on your location:
                        </li>
                        <li class="text-danger">Inside Bangladesh: Select <strong>Mobile Number</strong> and enter a valid number to receive OTP via SMS.</li>
                        <li class="text-danger">Outside Bangladesh: Select <strong>Email Address</strong> and enter a valid email to receive OTP via email.</li>
                        <li>After entering the appropriate information, click <strong>"Send OTP"</strong>.</li>
                        <li>You will receive a One-Time Password (OTP) via SMS or email.</li>
                        <li>Enter the 6-digit OTP to verify and access the voting page.</li>
                        <li><strong>Note:</strong> Each voter can vote only once. If you have already voted, the system
                            will not allow you to vote again.</li>
                    </ul>
                </div>

                <!-- Verification Form -->
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Voter Verification</h4>
                    </div>
                    <div class="card-body">
                        <!-- Alert box -->
                        <div id="alertBox" class="alert d-none" role="alert"></div>

                        <!-- Step 1: Selection Form -->
                        <form id="verification-form">
                            <div class="mb-3">
                                <label for="verify_by" class="form-label">Verify By</label>
                                <select class="form-select" id="verify_by" name="verify_by" required>
                                    <option value="" class="text-muted"> Select Mobile/Email</option>
                                    {{-- <option value="voter_number">Voter Number</option> --}}
                                    <option value="mobile">Mobile</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="input_field">
                                <label for="verify_value" class="form-label" id="verify_label"></label>
                                <input type="text" class="form-control" id="verify_value" name="verify_value"
                                    required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send OTP</button>
                            </div>
                        </form>

                        <!-- Step 2: OTP Form -->
                        <form id="otp-form" class="mt-4 d-none">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" maxlength="6"
                                    required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Verify OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            const verifyBy = document.getElementById('verify_by');
            const inputField = document.getElementById('input_field');
            const verifyLabel = document.getElementById('verify_label');
            const verifyValue = document.getElementById('verify_value');
            const alertBox = document.getElementById('alertBox');

            verifyBy.addEventListener('change', function() {
                const type = this.value;
                inputField.classList.toggle('d-none', !type);

                if (type === 'mobile') {
                    verifyLabel.textContent = 'Enter Mobile Number';
                    verifyValue.type = 'tel';
                    verifyValue.placeholder = '017XXXXXXXX';
                } else if (type === 'email') {
                    verifyLabel.textContent = 'Enter Email Address';
                    verifyValue.type = 'email';
                    verifyValue.placeholder = 'example@example.com';
                } else if (type === 'voter_number') {
                    verifyLabel.textContent = 'Enter Voter ID';
                    verifyValue.type = 'text';
                    verifyValue.placeholder = 'XXXX';
                }
            });

            function showAlert(type, message) {
                alertBox.className = `alert alert-${type}`;
                alertBox.textContent = message;
                alertBox.classList.remove('d-none');
            }

            document.getElementById('verification-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alertBox.classList.add('d-none');

                const formData = new FormData(this);

                fetch("{{ route('voter.send.otp') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('otp-form').classList.remove('d-none');
                            showAlert('success', 'OTP sent successfully.');
                        } else {
                            showAlert('danger', data.message || 'Failed to send OTP.');
                        }
                    })
                    .catch(() => showAlert('danger', 'Something went wrong. Please try again.'));
            });

            document.getElementById('otp-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alertBox.classList.add('d-none');

                const formData = new FormData(this);
                formData.append('verify_by', verifyBy.value);
                formData.append('verify_value', verifyValue.value);

                fetch("{{ route('voter.verify.otp') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const voterNumber = data.voter_number;
                            window.location.href = "{{ route('voting.index') }}" + "?voter_number=" +
                                encodeURIComponent(voterNumber);
                        } else {
                            showAlert('danger', data.message || 'Invalid OTP.');
                        }
                    })
                    .catch(() => showAlert('danger', 'Verification failed. Please try again.'));
            });
        </script>
</body>

</html>
