<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" class="img-circle elevation-2" href="{!! asset('dist/img/logo.png') !!}"/>
    <style>
        .candidate-option {
            cursor: pointer;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
            padding: 0.75rem 1rem;
        }

        .candidate-option:hover {
            background-color: #d2eaff;
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked + label {
            background-color: #004243;
            color: #fff;
        }

        label {
            width: 100%;
            display: block;
        }
    </style>
</head>

<body style="margin: 0;padding: 0;height: 100vh;width: 100vw;background: linear-gradient(135deg, #00608a, #2f0042, #490000);">
    <div class="container mt-5">
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="text-center text-white mb-4">Dhaka College Alumni Association HSC 96</h1>
        <div class="card shadow-lg border-0 rounded-4 bg-dark text-white">
            <div class="card-body text-center">
                <p class="card-text fs-6">
                    <span class="fw-semibold">Name:</span> {{ $voter->name }} <br>
                    <span class="fw-semibold">Voter Number:</span> {{ $voter->voter_number }}
                </p>
            </div>
        </div>
        {{-- Voting Instructions --}}
        <div class="alert alert-info shadow-sm rounded-3 mt-3" role="alert">
            {{-- <h5 class="mb-2"><i class="bi bi-info-circle-fill"></i> Voting Instructions</h5> --}}
            <ul class="mb-0 ps-3">
                <li>Please select <strong>one candidate</strong> for each position before submitting.</li>
                {{-- <li>Make sure to double-check your selections before submitting.</li> --}}
                <li>Once submitted, your vote cannot be changed.</li>
                {{-- <li>All fields are required to complete the vote.</li> --}}
            </ul>
        </div>
    </div>

    <section class="my-4">
        <form id="voteForm" action="{{ route('confirm.vote') }}" method="POST" class="container" novalidate>
            @csrf
            <input type="hidden" name="voter_number" value="{{ $voter->voter_number }}">
            <div class="row gx-3">
                <!-- President Section -->
                <div class="col-6 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 text-center"> Select President</h4>
                        </div>
                        <div class="card-body">
                            @foreach([
                                ['id' => 'radioManik', 'value' => 1, 'name' => 'ডা: মো: আশরাফুল হাসান মানিক'],
                                ['id' => 'radioKamal', 'value' => 2, 'name' => 'মুহাম্মদ কামাল হোসেন তালুকদার জীবন'],
                            ] as $candidate)
                                <div class="mb-2">
                                    <input type="radio" name="president" id="{{ $candidate['id'] }}" value="{{ $candidate['value'] }}"
                                        {{ old('president') == $candidate['value'] ? 'checked' : '' }} required>
                                    <label for="{{ $candidate['id'] }}" class="candidate-option shadow-sm border">
                                         ({{ $candidate['value'] }}) {{ $candidate['name'] }}
                                    </label>
                                </div>
                            @endforeach
                            @error('president')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Secretary Section -->
                <div class="col-6 mb-3">
                    <div class="card shadow-sm rounded-3">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 text-center">Selet Secretary</h4>
                        </div>
                        <div class="card-body">
                            @foreach([
                                ['id' => 'radioAlam', 'value' => 1, 'name' => 'মো: ওয়াহিদ আলম'],
                                ['id' => 'radioRabbi', 'value' => 2, 'name' => 'শাহ্ ফজলে রাব্বি']
                            ] as $candidate)
                                <div class="mb-2">
                                    <input type="radio" name="secretary" id="{{ $candidate['id'] }}" value="{{ $candidate['value'] }}"
                                        {{ old('secretary') == $candidate['value'] ? 'checked' : '' }} required>
                                    <label for="{{ $candidate['id'] }}" class="candidate-option shadow-sm border">
                                         ({{ $candidate['value'] }}) {{ $candidate['name'] }}
                                    </label>
                                </div>
                            @endforeach
                            @error('secretary')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            <div class="text-center my-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-bold text-uppercase">
                    Submit Vote
                </button>
            </div>
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('voteForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const presidentRadio = document.querySelector('input[name="president"]:checked');
                const secretaryRadio = document.querySelector('input[name="secretary"]:checked');

                if (!presidentRadio || !secretaryRadio) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Selection',
                        text: 'Please select both President and Secretary before submitting.',
                    });
                    return;
                }

                const presidentName = document.querySelector(`label[for="${presidentRadio.id}"]`).textContent.trim();
                const secretaryName = document.querySelector(`label[for="${secretaryRadio.id}"]`).textContent.trim();

                Swal.fire({
                    title: 'Confirm Your Vote',
                    html: `<strong>President:</strong> ${presidentName}<br><strong>Secretary:</strong> ${secretaryName}<br><br>Your vote will be submitted and <strong class='text-danger'>cannot be changed</strong>.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit vote',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
