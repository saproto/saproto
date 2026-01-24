<script setup lang="ts">
import { statsType } from '@/pages/Wrapped/types'

const props = defineProps<{
    data: statsType
}>()
const stats = props.data.days
const omnomcomdays = props.data.omnomcomdays
const year = new Date().getFullYear()
const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0
const months: [string, number][] = [
    ['January', 31],
    ['February', isLeapYear ? 29 : 28],
    ['March', 31],
    ['April', 30],
    ['May', 31],
    ['June', 30],
    ['July', 31],
    ['August', 31],
    ['September', 30],
    ['October', 31],
    ['November', 30],
    ['December', 31],
]

function isActive(month: number, day: number) {
    return omnomcomdays.has(
        `${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`
    )
}
</script>
<template>
  <div class="slide">
    <h1>
      This past year you used the OmNomCom
      <span class="header-text"><span class="dynamic">{{ stats.amount }}</span> days</span>
    </h1>
    <div class="calendar-container">
      <div
        v-for="month in 12"
        :key="month"
        style="width: 100%"
      >
        <i>
          {{ months[month - 1][0] }}
        </i>
        <div class="calendar">
          <div class="calendar-grid">
            <div
              v-for="day in 31"
              :key="day"
              class="day"
              :class="[
                isActive(month, day) ? 'active' : '',
                months[month - 1][1] >= day ? 'inactive' : '',
              ]"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.slide {
    background: rgb(34, 78, 255);
    background: linear-gradient(
        149deg,
        rgb(34, 78, 255) 0%,
        rgb(44, 92, 155) 49%,
        rgb(42, 40, 100) 98%
    );
    text-align: center;
    display: flex;
    flex-direction: column;
}

.day {
    gap: 2px;
    aspect-ratio: 1/1;
    border-radius: 0.2em;
}

.inactive {
    background: #ab87ff;
}

.header-text {
    color: #c0ff33;
}

.active {
    background: #c0ff33;
}

.calendar {
    aspect-ratio: 1/1;
    background: #272d2d90;

    border-radius: 0.5rem;
    padding: 0.5rem;
    overflow: hidden;
}

.calendar-grid {
    aspect-ratio: 1/1;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    grid-template-rows: repeat(5, 1fr);
    justify-content: space-evenly;
    align-items: center;
    gap: 0.2rem;
}

.calendar-container {
    display: grid;
    gap: 15px;
    grid-template-columns: repeat(3, 1fr);
}
</style>
