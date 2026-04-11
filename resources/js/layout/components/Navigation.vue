
<script setup lang="ts">
import { ref, computed, provide, onMounted, onBeforeUnmount } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { Menu, SearchIcon, X } from 'lucide-vue-next'
import type { AppPageProps } from '@/types'
import NavDropdown from './NavDropdown.vue'
import NavDropdownItem from './NavDropdownItem.vue'

// Routes
import { homepage } from '@/routes'
import { becomeamember } from '@/routes'
import { show as loginShow, logout as loginLogout } from '@/routes/namespaced/login'
import { index as registerIndex } from '@/routes/namespaced/login/register'
import { show as dashboardShow } from '@/routes/namespaced/user/dashboard'
import { profile as userProfile } from '@/routes/namespaced/user'
import { index as userAdminIndex } from '@/routes/namespaced/user/admin'
import { list as registrationHelperList } from '@/routes/namespaced/user/registrationhelper'
import { list as likedAlbumsList } from '@/routes/namespaced/albums/liked'
import { index as albumsAdminIndex } from '@/routes/namespaced/albums/admin'
import { dashboard as protubeDashboard } from '@/routes/namespaced/protube'
import { post as searchPost } from '@/routes/namespaced/search'
import { index as ordersHistoryIndex } from '@/routes/namespaced/omnomcom/orders'
import { adminlist as ordersAdminlist } from '@/routes/namespaced/omnomcom/orders'
import { index as omnomcomProductsIndex, statistics as omnomcomProductsStatistics } from '@/routes/namespaced/omnomcom/products'
import { index as omnomcomCategoriesIndex } from '@/routes/namespaced/omnomcom/categories'
import { generateorder, unwithdrawable } from '@/routes/namespaced/omnomcom'
import { orderhistory as tipcieOrderhistory } from '@/routes/namespaced/omnomcom/tipcie'
import { index as omnomcomAccountsIndex } from '@/routes/namespaced/omnomcom/accounts'
import { index as omnomcomWithdrawalIndex } from '@/routes/namespaced/omnomcom/withdrawal'
import { index as omnomcomMollieIndex } from '@/routes/namespaced/omnomcom/mollie'
import { statistics as omnomcomPaymentsStatistics } from '@/routes/namespaced/omnomcom/payments'
import { index as ticketsIndex } from '@/routes/namespaced/tickets'
import { index as shortUrlsIndex } from '@/routes/short_urls'
import { index as queriesIndex } from '@/routes/namespaced/queries'
import { index as tempadminsIndex } from '@/routes/tempadmins'
import { create as committeeCreate } from '@/routes/namespaced/committee'
import { create as eventCreate } from '@/routes/namespaced/event'
import { create as eventCategoriesCreate } from '@/routes/namespaced/event/categories'
import { list as eventFinancialList } from '@/routes/namespaced/event/financial'
import { admin as feedbackCategoryAdmin } from '@/routes/namespaced/feedback/category'
import { display as narrowcastingDisplay } from '@/routes/namespaced/narrowcasting'
import { admin as companiesAdmin } from '@/routes/namespaced/companies'
import { admin as joboffersAdmin } from '@/routes/namespaced/joboffers'
import { admin as leaderboardsAdmin } from '@/routes/namespaced/leaderboards'
import { edit as isAlfredThereEdit } from '@/routes/namespaced/minisites/isalfredthere'
import { list as menuList } from '@/routes/namespaced/menu'
import { index as videoAdminIndex } from '@/routes/namespaced/video/admin'
import { list as pageList } from '@/routes/namespaced/page'
import { admin as newsAdmin, create as newsCreate } from '@/routes/namespaced/news'
import { index as emailIndex } from '@/routes/namespaced/email'
import { index as achievementIndex } from '@/routes/namespaced/achievement'
import { index as welcomeMessagesIndex } from '@/routes/welcomeMessages'
import { index as headerimagesIndex } from '@/routes/headerimages'
import { index as aliasIndex } from '@/routes/namespaced/alias'
import { index as announcementIndex } from '@/routes/namespaced/announcement'
import { overview as authorizationOverview } from '@/routes/namespaced/authorization'
import { index as codexIndex } from '@/routes/codex'
import { index as passwordstoreIndex } from '@/routes/namespaced/passwordstore'
import { create as dinnerformCreate } from '@/routes/namespaced/dinnerform'
import { index as wallstreetIndex } from '@/routes/namespaced/wallstreet'

const page = usePage<AppPageProps>()
const user = computed(() => page.props.auth?.user ?? null)
const isLoggedIn = computed(() => user.value !== null)
const roles = computed(() => user.value?.roles ?? [])

const can = (role: string) => roles.value.includes(role)
const canAny = (r: string[]) => r.some(role => roles.value.includes(role))
const canAll = (r: string[]) => r.every(role => roles.value.includes(role))
const canNot = (role: string) => !can(role)

const menuItems = computed(() => page.props.menuitems ?? [])

function shouldShowItem(item: App.Data.MenuItemData) {
  return !item.is_member_only || (user.value?.is_member ?? false)
}

function sortedChildren(item: App.Data.MenuItemData) {
  return [...item.children].sort((a, b) => a.order - b.order)
}

// Centralized dropdown state: only one can be open at a time
const openDropdownId = ref<symbol | null>(null)
provide('nav-open-dropdown-id', openDropdownId)
provide('nav-set-open-dropdown', (id: symbol | null) => {
  openDropdownId.value = id
})

const navRef = ref<HTMLElement | null>(null)

function handleOutsideClick(event: MouseEvent) {
  if (navRef.value && !navRef.value.contains(event.target as Node)) {
    openDropdownId.value = null
  }
}

onMounted(() => document.addEventListener('click', handleOutsideClick))
onBeforeUnmount(() => document.removeEventListener('click', handleOutsideClick))

const isMobileMenuOpen = ref(false)
const searchQuery = ref('')

function submitSearch() {
  router.post(searchPost.url(), { query: searchQuery.value })
}

function logout() {
  router.post(loginLogout.url())
}
</script>

<template>
  <header>
    <nav
      ref="navRef"
      class="fixed inset-x-0 top-0 z-1030 bg-proto-primary text-white/75"
    >
      <div class="flex flex-wrap xl:flex-nowrap items-center px-3 py-2 w-full">
        <!-- Brand -->
        <a
          :href="homepage.url()"
          class="text-xl text-white/75 no-underline py-1 mr-4 whitespace-nowrap"
        >
          S.A. Proto
        </a>

        <!-- Mobile toggle -->
        <button
          type="button"
          class="xl:hidden ml-auto px-3 py-1 text-white/75 border border-white rounded bg-transparent cursor-pointer"
          aria-label="Toggle navigation"
          @click="isMobileMenuOpen = !isMobileMenuOpen"
        >
          <component
            :is="isMobileMenuOpen ? X : Menu"
            :size="22"
          />
        </button>

        <!-- Collapsible nav content -->
        <div
          :class="[
            'grow basis-full xl:basis-auto items-center',
            isMobileMenuOpen ? 'flex' : 'hidden',
            'xl:flex flex-col xl:flex-row',
          ]"
        >
          <!-- Main nav items -->
          <ul class="flex flex-col xl:flex-row pl-0 my-0 mr-auto list-none w-full xl:w-auto">
            <!-- Dynamic menu items from database -->
            <template
              v-for="item in menuItems"
              :key="item.menuname"
            >
              <li
                v-if="shouldShowItem(item)"
                class="relative"
              >
                <NavDropdown
                  v-if="item.children.length > 0"
                  :label="item.menuname"
                >
                  <NavDropdownItem
                    v-for="child in sortedChildren(item)"
                    v-show="shouldShowItem(child)"
                    :key="child.menuname"
                    :href="child.parsed_url ?? '#'"
                  >
                    {{ child.menuname }}
                  </NavDropdownItem>
                </NavDropdown>
                <a
                  v-else
                  :href="item.parsed_url ?? '#'"
                  class="block px-2 py-1.5 text-white/75 whitespace-nowrap no-underline hover:text-white font-medium transition-colors duration-150"
                >
                  {{ item.menuname }}
                </a>
              </li>
            </template>

            <!-- Auth-specific items -->
            <template v-if="isLoggedIn">
              <!-- OmNomCom -->
              <NavDropdown
                v-if="canAny(['omnomcom', 'tipcie', 'drafters'])"
                label="OmNomCom"
              >
                <template v-if="can('omnomcom')">
                  <NavDropdownItem :href="ordersAdminlist.url()">
                    Orders
                  </NavDropdownItem>
                  <NavDropdownItem :href="omnomcomProductsIndex.url()">
                    Products
                  </NavDropdownItem>
                  <NavDropdownItem :href="omnomcomCategoriesIndex.url()">
                    Categories
                  </NavDropdownItem>
                  <NavDropdownItem :href="generateorder.url()">
                    Generate Supplier Order
                  </NavDropdownItem>
                  <NavDropdownItem :href="omnomcomProductsStatistics.url()">
                    Sales statistics
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                </template>
                <template v-if="can('tipcie')">
                  <NavDropdownItem :href="dinnerformCreate.url()">
                    Dinnerforms
                  </NavDropdownItem>
                  <NavDropdownItem :href="tipcieOrderhistory.url()">
                    TIPCie Order Overview
                  </NavDropdownItem>
                  <NavDropdownItem :href="wallstreetIndex.url()">
                    Wallstreet Drinks
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                </template>
                <template v-if="canNot('board') && canAny(['tipcie', 'omnomcom'])">
                  <NavDropdownItem :href="passwordstoreIndex.url()">
                    Password Store
                  </NavDropdownItem>
                </template>
              </NavDropdown>

              <!-- Admin -->
              <NavDropdown
                v-if="canAny(['board', 'finadmin', 'alfred'])"
                label="Admin"
                panel-class="xl:max-h-[80vh] xl:overflow-y-auto"
              >
                <template v-if="can('board')">
                  <NavDropdownItem :href="userAdminIndex.url()">
                    Users
                  </NavDropdownItem>
                  <NavDropdownItem :href="ticketsIndex.url()">
                    Tickets
                  </NavDropdownItem>
                  <NavDropdownItem :href="shortUrlsIndex.url()">
                    Short URLs
                  </NavDropdownItem>
                  <NavDropdownItem :href="queriesIndex.url()">
                    Queries
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                  <NavDropdownItem :href="tempadminsIndex.url()">
                    Temp ProTube Admin
                  </NavDropdownItem>
                  <NavDropdownItem href="https://protu.be/remote">
                    ProTube Admin
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                  <NavDropdownItem :href="committeeCreate.url()">
                    Add Committee
                  </NavDropdownItem>
                  <NavDropdownItem :href="eventCreate.url()">
                    Add Event
                  </NavDropdownItem>
                  <NavDropdownItem :href="eventCategoriesCreate.url()">
                    Event Categories
                  </NavDropdownItem>
                  <NavDropdownItem :href="feedbackCategoryAdmin.url()">
                    Feedback Categories
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                  <NavDropdownItem :href="narrowcastingDisplay.url()">
                    Narrowcasting
                  </NavDropdownItem>
                  <NavDropdownItem :href="companiesAdmin.url()">
                    Companies
                  </NavDropdownItem>
                  <NavDropdownItem :href="joboffersAdmin.url()">
                    Job offers
                  </NavDropdownItem>
                  <NavDropdownItem :href="leaderboardsAdmin.url()">
                    Leaderboards
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                </template>
                <template v-if="can('closeactivities')">
                  <NavDropdownItem :href="eventFinancialList.url()">
                    Close Activities
                  </NavDropdownItem>
                </template>
                <template v-if="can('finadmin')">
                  <NavDropdownItem :href="omnomcomAccountsIndex.url()">
                    Accounts
                  </NavDropdownItem>
                  <NavDropdownItem :href="omnomcomWithdrawalIndex.url()">
                    Withdrawals
                  </NavDropdownItem>
                  <NavDropdownItem :href="unwithdrawable.url()">
                    Unwithdrawable
                  </NavDropdownItem>
                  <NavDropdownItem :href="omnomcomMollieIndex.url()">
                    Mollie Payments
                  </NavDropdownItem>
                  <NavDropdownItem :href="omnomcomPaymentsStatistics.url()">
                    Cash &amp; Card Payments
                  </NavDropdownItem>
                </template>
                <template v-if="canAny(['alfred', 'sysadmin'])">
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                  <NavDropdownItem :href="isAlfredThereEdit.url()">
                    Is Alfred There?
                  </NavDropdownItem>
                </template>
              </NavDropdown>

              <!-- Site (board members) -->
              <NavDropdown
                v-if="can('board')"
                label="Site"
              >
                <NavDropdownItem :href="menuList.url()">
                  Menu
                </NavDropdownItem>
                <NavDropdownItem :href="videoAdminIndex.url()">
                  Videos
                </NavDropdownItem>
                <NavDropdownItem :href="pageList.url()">
                  Pages
                </NavDropdownItem>
                <NavDropdownItem :href="newsAdmin.url()">
                  News
                </NavDropdownItem>
                <NavDropdownItem :href="emailIndex.url()">
                  Email
                </NavDropdownItem>
                <NavDropdownItem :href="achievementIndex.url()">
                  Achievements
                </NavDropdownItem>
                <NavDropdownItem :href="leaderboardsAdmin.url()">
                  Leaderboards
                </NavDropdownItem>
                <NavDropdownItem :href="welcomeMessagesIndex.url()">
                  Welcome Messages
                </NavDropdownItem>
                <NavDropdownItem :href="newsCreate.url({ query: { is_weekly: 1 } })">
                  Weekly Update
                </NavDropdownItem>
                <li
                  role="separator"
                  class="border-t border-border my-2"
                />
                <NavDropdownItem :href="headerimagesIndex.url()">
                  Header Images
                </NavDropdownItem>
                <NavDropdownItem :href="albumsAdminIndex.url()">
                  Photo Admin
                </NavDropdownItem>
                <template v-if="can('sysadmin')">
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                  <NavDropdownItem :href="aliasIndex.url()">
                    Aliases
                  </NavDropdownItem>
                  <NavDropdownItem :href="announcementIndex.url()">
                    Announcements
                  </NavDropdownItem>
                  <NavDropdownItem :href="authorizationOverview.url()">
                    Authorization
                  </NavDropdownItem>
                  <li
                    role="separator"
                    class="border-t border-border my-2"
                  />
                  <NavDropdownItem :href="codexIndex.url()">
                    Codices
                  </NavDropdownItem>
                </template>
                <li
                  role="separator"
                  class="border-t border-border my-2"
                />
                <NavDropdownItem :href="passwordstoreIndex.url()">
                  Password Store
                </NavDropdownItem>
              </NavDropdown>

              <!-- Non-board specific items -->
              <template v-if="canNot('board')">
                <li>
                  <a
                    href="https://protu.be"
                    target="_blank"
                    class="block px-2 py-1.5 text-white/75 whitespace-nowrap no-underline hover:text-white font-medium transition-colors duration-150"
                  >
                    ProTube
                  </a>
                </li>

                <!-- Site (protography + header-image) -->
                <NavDropdown
                  v-if="canAll(['protography', 'header-image'])"
                  label="Site"
                >
                  <NavDropdownItem :href="headerimagesIndex.url()">
                    Header Images
                  </NavDropdownItem>
                  <NavDropdownItem :href="albumsAdminIndex.url()">
                    Photo Admin
                  </NavDropdownItem>
                </NavDropdown>

                <!-- Photo Admin only (protography without header-image) -->
                <li v-else-if="can('protography')">
                  <a
                    :href="albumsAdminIndex.url()"
                    class="block px-2 py-1.5 text-white/75 whitespace-nowrap no-underline hover:text-white font-medium transition-colors duration-150"
                  >
                    Photo Admin
                  </a>
                </li>

                <li v-if="can('registermembers')">
                  <a
                    :href="registrationHelperList.url()"
                    class="block px-2 py-1.5 text-white/75 whitespace-nowrap no-underline hover:text-white font-medium transition-colors duration-150"
                  >
                    Registration Helper
                  </a>
                </li>

                <li v-if="can('senate')">
                  <a
                    :href="codexIndex.url()"
                    class="block px-2 py-1.5 text-white/75 whitespace-nowrap no-underline hover:text-white font-medium transition-colors duration-150"
                  >
                    Codices
                  </a>
                </li>
              </template>
            </template>
          </ul>

          <!-- Search form -->
          <form
            class="flex mr-2 mt-2 xl:mt-0"
            @submit.prevent="submitSearch"
          >
            <input
              v-model="searchQuery"
              class="py-1 px-3 text-black bg-white border border-neutral-300 rounded-l-md focus:outline-none"
              style="max-width: 125px"
              placeholder="Search"
              type="search"
              name="query"
            />
            <button
              type="submit"
              class="px-3 py-1 bg-proto-success text-white border border-proto-success rounded-r-md cursor-pointer"
            >
              <SearchIcon :size="18" />
            </button>
          </form>

          <!-- User section -->
          <div class="mt-2 xl:mt-0">
            <!-- Logged in: user dropdown -->
            <ul
              v-if="isLoggedIn"
              class="flex flex-col xl:flex-row pl-0 my-0 list-none"
            >
              <NavDropdown
                :label="user?.calling_name ?? ''"
                right-align
              >
                <template #trigger-suffix>
                  <img
                    id="profile-picture"
                    class="w-10 h-10 rounded-full border-2 border-white -my-3"
                    alt="your profile picture"
                    :src="user?.avatar"
                  />
                </template>
                <NavDropdownItem :href="dashboardShow.url()">
                  Dashboard
                </NavDropdownItem>
                <template v-if="user?.is_member">
                  <NavDropdownItem :href="userProfile.url()">
                    My Profile
                  </NavDropdownItem>
                  <NavDropdownItem :href="likedAlbumsList.url()">
                    My Liked Photos
                  </NavDropdownItem>
                </template>
                <template v-else>
                  <NavDropdownItem :href="becomeamember.url()">
                    Become a member!
                  </NavDropdownItem>
                </template>
                <NavDropdownItem
                  href="https://saproto.nl/go/discord"
                  target="_blank"
                >
                  <span class="fa-brands fa-discord" />
                  Discord
                  <span class="inline-block py-0.5 px-1.5 text-xs font-bold text-white bg-gray-500 rounded -translate-y-px">
                    <i class="fas fa-user mr-1" />
                    <span id="discord__online">
                      ...
                    </span>
                  </span>
                </NavDropdownItem>
                <NavDropdownItem :href="protubeDashboard.url()">
                  ProTube Dashboard
                </NavDropdownItem>
                <NavDropdownItem :href="ordersHistoryIndex.url()">
                  Purchase History
                </NavDropdownItem>
                <li>
                  <button
                    type="button"
                    class="block w-full text-left px-4 py-1 text-card-foreground whitespace-nowrap hover:bg-accent bg-transparent border-0 cursor-pointer"
                    @click="logout"
                  >
                    Logout
                  </button>
                </li>
              </NavDropdown>
            </ul>

            <!-- Not logged in: register/login buttons -->
            <div
              v-else
              class="flex gap-2"
            >
              <a
                :href="registerIndex.url()"
                class="px-3 py-1.5 text-white border border-white rounded hover:bg-white/10 no-underline whitespace-nowrap"
              >
                <i class="fas fa-user-plus mr-2" />
                Register
              </a>
              <a
                :href="loginShow.url()"
                class="px-3 py-1.5 bg-white text-proto-primary rounded hover:bg-white/90 no-underline whitespace-nowrap font-medium"
              >
                <i class="fas fa-id-card mr-2" />
                Log in
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>
