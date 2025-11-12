@extends('backend.partials.master')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                
                <!--begin::Profile Card-->
                <div class="card card-flush shadow-sm mb-8">
                    <div class="card-header pt-7 pb-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900 fs-2">My Profile</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-7">Manage your account information</span>
                        </h3>
                    </div>
                    <div class="card-body pt-2">
                        <form action="{{ route('customer.profile.update') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Name</label>
                                <div class="col-lg-8">
                                    <input type="text" name="name" class="form-control form-control-solid" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Email</label>
                                <div class="col-lg-8">
                                    <input type="email" name="email" class="form-control form-control-solid" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Phone</label>
                                <div class="col-lg-8">
                                    <input type="text" name="phone" class="form-control form-control-solid" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Country</label>
                                <div class="col-lg-8">
                                    <input type="text" name="country" class="form-control form-control-solid" value="{{ old('country', $user->country) }}">
                                    @error('country')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">City</label>
                                <div class="col-lg-8">
                                    <input type="text" name="city" class="form-control form-control-solid" value="{{ old('city', $user->city) }}">
                                    @error('city')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Address</label>
                                <div class="col-lg-8">
                                    <textarea name="address" class="form-control form-control-solid" rows="3">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="separator separator-dashed my-8"></div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">New Password</label>
                                <div class="col-lg-8">
                                    <input type="password" name="password" class="form-control form-control-solid" placeholder="Leave blank to keep current password">
                                    @error('password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Confirm Password</label>
                                <div class="col-lg-8">
                                    <input type="password" name="password_confirmation" class="form-control form-control-solid" placeholder="Confirm new password">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ki-outline ki-check fs-2"></i>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end::Profile Card-->
                
            </div>
        </div>
    </div>
@endsection

