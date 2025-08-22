@extends('layouts.master')
@section('title', 'Bikroyik :: Home')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
        height: 99vh;
        margin: 0;
        padding: 0;
    }

    .content-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #4caf50, #009688);
        color: #fff;
    }

    .welcome-container {
        text-align: center;
        padding: 2rem;
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.4);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .welcome-container h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .welcome-container p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .icon-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, background 0.3s;
    }

    .icon-box:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.2);
    }

    .icon-box i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .icon-box span {
        font-size: 1rem;
        color: #fff;
    }
</style>

@section('content')
    <div class="content-wrapper">
        <div class="welcome-container">
            <h1><b>Welcome to the Bikroyik Admin Portal!</b></h1>
            <p>Manage your platform effectively with our easy-to-use interface.</p>
            <div class="icon-grid">
                <a href="#">
                    <div class="icon-box">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile</span>
                    </div>
                </a>

                <a href="#">
                    <div class="icon-box">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </div>
                </a>

                <a href="#">
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                        <span>Purchases</span>
                    </div>
                </a>

                <a href="#">
                    <div class="icon-box">
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                    </div>
                </a>

            </div>
        </div>
    </div>
@endsection
