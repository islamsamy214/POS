<template>
  <div class="topnav">
    <div class="container-fluid">
      <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div class="collapse navbar-collapse" id="topnav-menu-content">
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
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>