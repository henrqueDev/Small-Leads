<script setup>


import NavLink from '@/Components/NavLink.vue';

defineProps({
  links: {
    type: Object,
    required: true,
  },
});

const currentUrl = new URL(window.location.href);
</script>

<template>
  <section
    class="flex items-center bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
  >
    <div class="w-full max-w-screen-lg px-1 mx-auto lg:px-12">
      <!-- Start coding here -->
      <div
        class="relative overflow-hidden bg-white rounded-b-lg shadow-md dark:bg-gray-800"
      >
        <nav
          class="flex flex-col items-start justify-between p-1 space-y-2 md:flex-row md:items-center md:space-y-0"
          aria-label="Table navigation"
        >
          <span class="text-sm font-normal text-gray-500 dark:text-gray-400"
            >Showing
            <span class="font-semibold text-gray-900 dark:text-white">1-10</span> of
            <span class="font-semibold text-gray-900 dark:text-white">1000</span></span
          >
          <ul class="inline-flex items-stretch -space-x-px">
            <li 
              v-for="(link, i) in links"
              :key="i"
            >
              <NavLink
                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                :href="link.url"
                :active="(link.url == currentUrl) || ((!currentUrl.searchParams.has('page')) && (i===1)) ? true : false"
              >
                {{
                  link.label.replaceAll("&amp;laquo;", "").replaceAll("&amp;raquo;", "")
                }}
              </NavLink>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</template>
