@php
    $current_route = Route::current()->getName();
@endphp

<ul class="nav">
    <li class="nav-item">
        <a @class(["nav-link", "nav-link_active" => $current_route === 'app/main']) href="/app/main">User</a>
    </li>
    <li class="nav-item">
        <a @class(["nav-link", "nav-link_active" => $current_route === 'app/bindings']) href="/app/bindings">Bindings</a>
    </li>
    <li class="nav-item">
        <a @class(["nav-link", "nav-link_active" => $current_route === 'app/settings']) href="/app/settings">Settings</a>
    </li>
    <li class="nav-item">
        <form method="POST" action="/app/logout">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </li>
</ul>
