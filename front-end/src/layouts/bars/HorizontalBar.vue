<template>
  <div class="topnav">
    <div class="container-fluid">
      <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div
          class="collapse navbar-collapse justify-content-center"
          id="topnav-menu-content"
        >
          <ul class="navbar-nav">
            <!-- links -->
            <li class="nav-item dropdown">
              <router-link
                :to="{ name: 'home' }"
                class="nav-link dropdown-toggle arrow-none"
                id="topnav-dashboard"
                role="button"
              >
                <icon icon="material-symbols:garage-home"></icon>
                <span>Home</span>
              </router-link>
            </li>
            <li class="nav-item dropdown">
              <router-link
                :to="{ name: 'users' }"
                class="nav-link dropdown-toggle arrow-none"
                id="topnav-dashboard"
                role="button"
              >
                <icon icon="mdi:users-group"></icon>
                <span>Users</span>
              </router-link>
            </li>
            <li class="nav-item dropdown">
              <router-link
                :to="{ name: 'brands' }"
                class="nav-link dropdown-toggle arrow-none"
                id="topnav-dashboard"
                role="button"
              >
                <icon icon="tabler:brand-4chan"></icon>
                <span>Brands</span>
              </router-link>
            </li>
            <li class="nav-item dropdown">
              <router-link
                :to="{ name: 'orders' }"
                class="nav-link dropdown-toggle arrow-none"
                id="topnav-dashboard"
                role="button"
              >
                <icon icon="icon-park-outline:order"></icon>
                <span>Orders</span>
              </router-link>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>