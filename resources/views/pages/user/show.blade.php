@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data User</h1>
                <div class="section-header-breadcrumb d-flex justify-content-center">
                    <a href="{{ route('user.index', $user->id) }}" class="btn btn-secondary">Back</a>
                </div>
            </div>

            <div class="section-body d-flex justify-content-center">
                <div class="card" style="width: 750px;">
                    <div class="card-header">
                        <h4>User Profile</h4>
                    </div>

                    <div class="card-body text-center">
                        {{-- Foto Profil --}}
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                class="rounded-circle shadow-sm" width="150" height="150"
                                style="object-fit: cover; border: 3px solid #ddd;">
                        </div>

                        {{-- Data User --}}
                        <div class="text-left px-5">
                            <div class="form-group">
                                <label>Name</label>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <p>{{ $user->address }}</p>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <p>{{ $user->phone_number }}</p>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <p>••••••••</p>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <p>{{ ($user->role) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 2px;
        }

        .form-group p {
            margin: 0 0 10px 0;
            color: #333;
        }

        .rounded-circle {
            border: 3px solid #e5e5e5;
        }
    </style>
@endsection
