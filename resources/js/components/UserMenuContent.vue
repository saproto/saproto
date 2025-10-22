<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue'
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu'
// import { edit } from '@/routes/profile'
import { Link, router } from '@inertiajs/vue3'
import { LogOut, Settings } from 'lucide-vue-next'
import AuthController from '@/actions/App/Http/Controllers/AuthController'

interface Props {
    user: App.Data.AuthUserData
}

const handleLogout = () => {
    router.flushAll()
}

defineProps<Props>()
</script>

<template>
  <DropdownMenuLabel class="p-0 font-normal">
    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
      <UserInfo
        :user="user"
        :show-email="true"
      />
    </div>
  </DropdownMenuLabel>
  <DropdownMenuSeparator />
  <DropdownMenuGroup>
    <DropdownMenuItem :as-child="true">
      <Link
        class="block w-full"
        :href="'/edit/setting'"
        prefetch
        as="button"
      >
        <Settings class="mr-2 h-4 w-4" />
        Settings
      </Link>
    </DropdownMenuItem>
  </DropdownMenuGroup>
  <DropdownMenuSeparator />
  <DropdownMenuItem :as-child="true">
    <Link
      class="block w-full"
      :href="AuthController.logout().url"
      as="button"
      data-test="logout-button"
      @click="handleLogout"
    >
      <LogOut class="mr-2 h-4 w-4" />
      Log out
    </Link>
  </DropdownMenuItem>
</template>
