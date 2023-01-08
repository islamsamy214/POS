<template>
  <div class="row">
    <div class="col-xl-4 col-sm-6" v-for="i in 9" :key="i">
      <div class="card">
        <div class="">
          <img
            src="../../../assets/images/small/img-3.jpg"
            alt=""
            class="img-fluid"
          />
        </div>
        <div class="card-body">
          <p class="text-muted mb-2">10 Apr, 2022</p>
          <h5 class="">
            <a href="#" class="text-dark">Beautiful Day with Friends</a>
          </h5>
          <p class="mb-0 font-size-15">
            Contrary to popular belief, Lorem Ipsum is not simply random text,a
            Latin professor at Hampden-Sydney College in Virginia.
          </p>
          <div class="mt-3 row">
            <router-link
              :to="{
                name: 'products-show',
                params: { product_sku: 'lorem' },
              }"
              class="align-middle font-size-15 col"
              >Read more
              <icon icon="material-symbols:chevron-right-rounded"></icon>
            </router-link>
            <button
              class="
                btn btn-link
                waves-effect
                align-middle
                font-size-15
                col
                text-end text-decoration-none
                p-0
              "
            >
              <icon
                icon="material-symbols:add-shopping-cart-outline-rounded"
              ></icon>
              Add to cart
            </button>
          </div>
        </div>
      </div>
      <!-- end card -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->

  <div class="row justify-content-center mb-4">
    <div class="col-md-3">
      <div class="">
        <ul class="pagination mb-sm-0">
          <li class="page-item disabled">
            <a href="#" class="page-link">
              <icon icon="material-symbols:chevron-left-rounded"></icon>
            </a>
          </li>
          <li class="page-item">
            <a href="#" class="page-link">1</a>
          </li>
          <li class="page-item active">
            <a href="#" class="page-link">2</a>
          </li>
          <li class="page-item">
            <a href="#" class="page-link">3</a>
          </li>
          <li class="page-item">
            <a href="#" class="page-link">4</a>
          </li>
          <li class="page-item">
            <a href="#" class="page-link">5</a>
          </li>
          <li class="page-item">
            <a href="#" class="page-link">
              <icon icon="material-symbols:chevron-right-rounded"></icon>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- end row -->
</template>