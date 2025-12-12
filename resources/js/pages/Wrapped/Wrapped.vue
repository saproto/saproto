<script setup lang="ts">
import './wrapped.css'
import { computed, ref } from 'vue'
import SlideShow from '@/pages/Wrapped/Components/SlideShow.vue'
import { prepareStats } from '@/lib/stats'
import { Head, usePage } from '@inertiajs/vue3'
import { statsType } from '@/pages/Wrapped/types'

const page = usePage()
const data = ref({} as statsType)
const purchases = computed(
    () => page.props.purchases as Array<App.Data.OrderlineData>
)
const order_totals = computed(() => page.props.order_totals as number[][])
const total_spent = computed(() => page.props.total_spent as number)
const events = computed(() => page.props.events as { price: number }[])
const loaded = ref(false)
const steps = 1
const currentStep = ref(0)

const loadData = async () => {
    currentStep.value++
    data.value = await prepareStats(
        purchases.value,
        order_totals.value,
        total_spent.value,
        events.value,
    )
    currentStep.value++
    await new Promise((resolve) => setTimeout(resolve, 1000))
    loaded.value = true
}
loadData()
</script>

<template>
    <Head title="Wrapped" />
    <Transition>
        <main v-if="loaded">
            <SlideShow :data="data" />
        </main>
        <main v-else id="welcome">
            <h1>Welcome to <span class="omnomcom">OmNomCom</span> Wrapped</h1>
            <div id="loader">
                <div class="bar">
                    <div
                        class="progress-bar"
                        :style="{ width: (currentStep / steps) * 100 + '%' }"
                    />
                </div>
                <div>
                    Loading:
                    <span id="loading" />
                </div>
            </div>
        </main>
    </Transition>
</template>

<style scoped>
#welcome {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100svh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    gap: 2em;
    font-size: min(1em, 2vw);
}

#welcome h1 {
    font-size: 3em;
}

button {
    font-size: 1.5em;
    color: white;
    padding: 0.5em;
    background: rgb(50, 50, 255);
    border: 0;
    border-radius: 0.5em;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    box-shadow: rgba(0, 0, 255, 0.5) 0 0 1em 0.5em;
}

#loader {
    font-size: 2em;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.bar {
    width: 15em;
    height: 0.3em;
    background: grey;
    margin: 0 0.2em;
    border-radius: 0.1em;
}

.progress-bar {
    content: '';
    display: block;
    background: white;
    border-radius: 0.1em;
    height: 0.3em;
    width: 0;
    transition: width 0.5s;
}

#loading:after {
    animation: loading 10s linear infinite;
    animation-delay: 2s;
    content: 'Collecting your data';
}

@keyframes loading {
    0% {
        content: 'Eating your data';
    }
    15% {
        content: 'Placing some cookies';
    }
    30% {
        content: 'Eating cookie warning';
    }
    45% {
        content: 'Consuming cookie policy';
    }
    60% {
        content: 'Thanking Beheer';
    }
    75% {
        content: 'Cooooookiiiieeeees!';
    }
    90% {
        content: 'Recollecting your data';
    }
    100% {
        content: 'Eating your data';
    }
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
