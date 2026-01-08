@extends('layouts.app')

@section('title', 'Notifikasi - RuangRasa')

@section('content')
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <span class="page-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </span>
            <h1>Notifikasi</h1>
        </div>

        <!-- Notifications Card -->
        <div class="notifications-card">
            @php
                $currentCategory = '';
            @endphp

            @foreach($notifications as $notification)
                @if($notification['category'] !== $currentCategory)
                    @php $currentCategory = $notification['category']; @endphp
                    <div class="notification-category">
                        @if($currentCategory === 'like')
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                            <span>Menyukai</span>
                        @elseif($currentCategory === 'share')
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="17 1 21 5 17 9"></polyline>
                                <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                                <polyline points="7 23 3 19 7 15"></polyline>
                                <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                            </svg>
                            <span>Membagikan ulang</span>
                        @elseif($currentCategory === 'comment')
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Mengomentari</span>
                        @endif
                    </div>
                @endif

                <div class="notification-item {{ $notification['highlighted'] ? 'highlighted' : '' }}">
                    <div class="notification-avatar">
                        @if($notification['avatar'])
                            <img src="{{ $notification['avatar'] }}" alt="{{ $notification['user'] }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#6B7B4B" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        @endif
                    </div>
                    <div class="notification-content">
                        <p class="notification-text">
                            <strong>{{ $notification['user'] }}</strong>
                            {{ $notification['action'] }}
                            @if($notification['ruang'])
                                pada <strong>{{ $notification['ruang'] }}</strong>
                            @endif
                        </p>
                        <p class="notification-preview">{{ $notification['preview'] }}</p>
                    </div>
                    <span class="notification-time">{{ $notification['time'] }}</span>
                </div>
            @endforeach
        </div>

        <!-- Load More -->
        <div class="load-more-container">
            <button class="load-more-btn">Lihat notifikasi lainnya...</button>
        </div>
    </div>
@endsection