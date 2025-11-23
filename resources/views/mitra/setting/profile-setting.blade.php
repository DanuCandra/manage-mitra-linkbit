@extends('layouts.main')
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Account Setting</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Account Setting</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="../assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button"
                    role="tab" aria-controls="pills-account" aria-selected="true">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Account</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-notifications-tab" data-bs-toggle="pill" data-bs-target="#pills-notifications" type="button"
                    role="tab" aria-controls="pills-notifications" aria-selected="false">
                    <i class="ti ti-bell me-2 fs-6"></i>
                    <span class="d-none d-md-block">Notifications</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-bills-tab" data-bs-toggle="pill" data-bs-target="#pills-bills" type="button" role="tab"
                    aria-controls="pills-bills" aria-selected="false">
                    <i class="ti ti-article me-2 fs-6"></i>
                    <span class="d-none d-md-block">Bills</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-security" type="button"
                    role="tab" aria-controls="pills-security" aria-selected="false">
                    <i class="ti ti-lock me-2 fs-6"></i>
                    <span class="d-none d-md-block">Security</span>
                </button>
            </li>
        </ul>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
    aria-labelledby="pills-account-tab" tabindex="0">

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

    <div class="row">
        <!-- Change Profile Photo -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100 border position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h4 class="card-title">Change Profile</h4>
                    <p class="card-subtitle mb-4">Change your profile picture from here</p>
                    <form action="{{ route('setting.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">
                            <img src="{{ $user->profile_photo ? asset('storage/profile-foto/' . $user->profile_photo) : asset('assets/images/profile/user-1.jpg') }}"
                                alt="Profile Photo"
                                class="rounded-circle"
                                width="120"
                                height="120"
                                style="object-fit: cover; width: 120px; height: 120px;"
                                id="profilePreview">
                            <div class="d-flex align-items-center justify-content-center my-4 gap-6">
                                <input type="file" name="profile_photo" id="profilePhotoInput" class="d-none" accept="image/*">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('profilePhotoInput').click()">Upload</button>
                                @if($user->profile_photo)
                                    <input type="hidden" name="delete_photo" id="deletePhotoInput" value="0">
                                    <button type="button" class="btn bg-danger-subtle text-danger" onclick="resetPhoto()">Reset</button>
                                @endif
                            </div>
                            <p class="mb-3">Allowed JPG, GIF or PNG. Max size of 5MB</p>
                            @error('profile_photo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-success">Save Photo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100 border position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h4 class="card-title">Change Password</h4>
                    <p class="card-subtitle mb-4">To change your password please confirm here</p>
                    <form action="{{ route('setting.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" placeholder="Enter current password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password" placeholder="Enter new password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control"
                                id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password">
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="col-12">
            <div class="card w-100 border position-relative overflow-hidden mb-0">
                <div class="card-body p-4">
                    <h4 class="card-title">Personal Details</h4>
                    <p class="card-subtitle mb-4">To change your personal detail, edit and save from here</p>
                    <form action="{{ route('setting.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Your Name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="email@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                        id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="+62 812 3456 7890">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ url()->previous() }}" class="btn bg-danger-subtle text-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview image before upload
    document.getElementById('profilePhotoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Reset photo function
    function resetPhoto() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            document.getElementById('deletePhotoInput').value = '1';
            document.getElementById('profilePreview').src = "{{ asset('assets/images/profile/user-1.jpg') }}";
            // Submit form
            this.closest('form').submit();
        }
    }
</script>
                <div class="tab-pane fade" id="pills-notifications" role="tabpanel"
                    aria-labelledby="pills-notifications-tab" tabindex="0">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Notification Preferences</h4>
                                    <p class="card-subtitle mb-4">
                                        Select the notificaitons ou would like to receive via email. Please note that you
                                        cannot opt
                                        out of receving service
                                        messages, such as payment, security or legal notifications.
                                    </p>
                                    <form class="mb-7">
                                        <label for="exampleInputtext5" class="form-label">Email Address*</label>
                                        <input type="text" class="form-control" id="exampleInputtext5" placeholder=""
                                            required>
                                        <p class="mb-0">Required for notificaitons.</p>
                                    </form>
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-article text-dark d-block fs-7" width="22"
                                                        height="22"></i>
                                                </div>
                                                <div>
                                                    <h5 class="fs-4 fw-semibold">Our newsletter</h5>
                                                    <p class="mb-0">We'll always let you know about important changes</p>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-checkbox text-dark d-block fs-7" width="22"
                                                        height="22"></i>
                                                </div>
                                                <div>
                                                    <h5 class="fs-4 fw-semibold">Order Confirmation</h5>
                                                    <p class="mb-0">You will be notified when customer order any product
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked1" checked>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-clock-hour-4 text-dark d-block fs-7" width="22"
                                                        height="22"></i>
                                                </div>
                                                <div>
                                                    <h5 class="fs-4 fw-semibold">Order Status Changed</h5>
                                                    <p class="mb-0">You will be notified when customer make changes to
                                                        the order</p>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked2" checked>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-truck-delivery text-dark d-block fs-7" width="22"
                                                        height="22"></i>
                                                </div>
                                                <div>
                                                    <h5 class="fs-4 fw-semibold">Order Delivered</h5>
                                                    <p class="mb-0">You will be notified once the order is delivered</p>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked3">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-mail text-dark d-block fs-7" width="22"
                                                        height="22"></i>
                                                </div>
                                                <div>
                                                    <h5 class="fs-4 fw-semibold">Email Notification</h5>
                                                    <p class="mb-0">Turn on email notificaiton to get updates through
                                                        email</p>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked4" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Date & Time</h4>
                                    <p class="card-subtitle">Time zones and calendar display settings.</p>
                                    <div class="d-flex align-items-center justify-content-between mt-7">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-clock-hour-4 text-dark d-block fs-7" width="22"
                                                    height="22"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0">Time zone</p>
                                                <h5 class="fs-4 fw-semibold">(UTC + 02:00) Athens, Bucharet</h5>
                                            </div>
                                        </div>
                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                                            href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Download">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Ignore Tracking</h4>
                                    <div class="d-flex align-items-center justify-content-between mt-7">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-player-pause text-dark d-block fs-7" width="22"
                                                    height="22"></i>
                                            </div>
                                            <div>
                                                <h5 class="fs-4 fw-semibold">Ignore Browser Tracking</h5>
                                                <p class="mb-0">Browser Cookie</p>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="flexSwitchCheckChecked5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-end gap-6">
                                <button class="btn btn-primary">Save</button>
                                <button class="btn bg-danger-subtle text-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-bills" role="tabpanel" aria-labelledby="pills-bills-tab"
                    tabindex="0">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-3">Billing Information</h4>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext6" class="form-label">Business
                                                        Name*</label>
                                                    <input type="text" class="form-control" id="exampleInputtext6"
                                                        placeholder="Visitor Analytics">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext7" class="form-label">Business
                                                        Address*</label>
                                                    <input type="text" class="form-control" id="exampleInputtext7"
                                                        placeholder="">
                                                </div>
                                                <div>
                                                    <label for="exampleInputtext8" class="form-label">First Name*</label>
                                                    <input type="text" class="form-control" id="exampleInputtext8"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext9" class="form-label">Business
                                                        Sector*</label>
                                                    <input type="text" class="form-control" id="exampleInputtext9"
                                                        placeholder="Arts, Media & Entertainment">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext10" class="form-label">Country*</label>
                                                    <input type="text" class="form-control" id="exampleInputtext10"
                                                        placeholder="Romania">
                                                </div>
                                                <div>
                                                    <label for="exampleInputtext11" class="form-label">Last Name*</label>
                                                    <input type="text" class="form-control" id="exampleInputtext11"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Current Plan : <span class="text-success">Executive</span>
                                    </h4>
                                    <p class="card-subtitle">Thanks for being a premium member and supporting our
                                        development.</p>
                                    <div class="d-flex align-items-center justify-content-between mt-7 mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-package text-dark d-block fs-7" width="22"
                                                    height="22"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0">Current Plan</p>
                                                <h5 class="fs-4 fw-semibold">750.000 Monthly Visits</h5>
                                            </div>
                                        </div>
                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                                            href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Add">
                                            <i class="ti ti-circle-plus"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <button class="btn btn-primary">Change Plan</button>
                                        <button class="btn bg-danger-subtle text-danger">Reset Plan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Payment Method</h4>
                                    <p class="card-subtitle">On 26 December, 2024</p>
                                    <div class="d-flex align-items-center justify-content-between mt-7">
                                        <div class="d-flex align-items-center gap-3">
                                            <div
                                                class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-credit-card text-dark d-block fs-7" width="22"
                                                    height="22"></i>
                                            </div>
                                            <div>
                                                <h5 class="fs-4 fw-semibold">Visa</h5>
                                                <p class="mb-0 text-dark">*****2102</p>
                                            </div>
                                        </div>
                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                                            href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Edit">
                                            <i class="ti ti-pencil-minus"></i>
                                        </a>
                                    </div>
                                    <p class="my-2">If you updated your payment method, it will only be dislpayed here
                                        after your
                                        next billing cycle.</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <button class="btn bg-danger-subtle text-danger">Cancel Subscription</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-end gap-6">
                                <button class="btn btn-primary">Save</button>
                                <button class="btn bg-danger-subtle text-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-security" role="tabpanel" aria-labelledby="pills-security-tab"
                    tabindex="0">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card border shadow-none">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-3">Two-factor Authentication</h4>
                                    <div class="d-flex align-items-center justify-content-between pb-7">
                                        <p class="card-subtitle mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing
                                            elit. Corporis sapiente
                                            sunt earum officiis laboriosam ut.</p>
                                        <button class="btn btn-primary">Enable</button>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between py-3 border-top">
                                        <div>
                                            <h5 class="fs-4 fw-semibold mb-0">Authentication App</h5>
                                            <p class="mb-0">Google auth app</p>
                                        </div>
                                        <button class="btn bg-primary-subtle text-primary">Setup</button>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between py-3 border-top">
                                        <div>
                                            <h5 class="fs-4 fw-semibold mb-0">Another e-mail</h5>
                                            <p class="mb-0">E-mail to send verification link</p>
                                        </div>
                                        <button class="btn bg-primary-subtle text-primary">Setup</button>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between py-3 border-top">
                                        <div>
                                            <h5 class="fs-4 fw-semibold mb-0">SMS Recovery</h5>
                                            <p class="mb-0">Your phone number or something</p>
                                        </div>
                                        <button class="btn bg-primary-subtle text-primary">Setup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div
                                        class="text-bg-light rounded-1 p-6 d-inline-flex align-items-center justify-content-center mb-3">
                                        <i class="ti ti-device-laptop text-primary d-block fs-7" width="22"
                                            height="22"></i>
                                    </div>
                                    <h4 class="card-title mb-0">Devices</h4>
                                    <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit Rem.</p>
                                    <button class="btn btn-primary mb-4">Sign out from all devices</button>
                                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="ti ti-device-mobile text-dark d-block fs-7" width="26"
                                                height="26"></i>
                                            <div>
                                                <h5 class="fs-4 fw-semibold mb-0">iPhone 14</h5>
                                                <p class="mb-0">London UK, Oct 23 at 1:15 AM</p>
                                            </div>
                                        </div>
                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                                            href="javascript:void(0)">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="ti ti-device-laptop text-dark d-block fs-7" width="26"
                                                height="26"></i>
                                            <div>
                                                <h5 class="fs-4 fw-semibold mb-0">Macbook Air</h5>
                                                <p class="mb-0">Gujarat India, Oct 24 at 3:15 AM</p>
                                            </div>
                                        </div>
                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                                            href="javascript:void(0)">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                    </div>
                                    <button class="btn bg-primary-subtle text-primary w-100 py-1">Need Help ?</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-end gap-6">
                                <button class="btn btn-primary">Save</button>
                                <button class="btn bg-danger-subtle text-danger">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
