import cookieMonster from '@/../assets/images/cookiemonster.png'
import beugel from '@/../assets/images/beugel.webp'
import lemonade from '@/../assets/images/lemonade.png'
import spilledBeer from '@/../assets/images/spilledbeer.png'
import tosti from '@/../assets/images/tosti.png'
import unicorn from '@/../assets/images/unicorn.png'
import unicornBw from '@/../assets/images/unicorn_bw.png'
import OrderlineData = App.Data.OrderlineData
import ProductData = App.Data.ProductData
import { statsType } from '@/pages/Wrapped/types'
export const prepareStats = async (
    orders: Array<OrderlineData>,
    order_totals: number[][],
    total_spent: number,
    events: Array<{ price: number }>
) => {
    const caloriesTotal = orders
        .map((x) => x.units * x.product.calories)
        .reduce((a, b) => a + b)
    const stats: statsType = {
        activities: {
            amount: events.length,
            spent:
                events.length <= 0
                    ? 0
                    : events
                          .map((x: { price: number }) => x.price)
                          .reduce((a, b) => a + b)
                          .toFixed(2),
            all: events,
        },
        calories: {
            amount: caloriesTotal,
            tostis: Math.round(caloriesTotal / 251),
        },
        days: {
            items: 0,
            amount: 0,
        },
        drinks: {
            alcoholic: 0,
            nonAlcoholic: 0,
            amount: 0,
        },
        omnomcomdays: new Set<string>(),
        mostBought: {
            items: [],
            percentile: 0,
        },
        totalSpent: {
            amount: orders.map((x) => x.total_price).reduce((a, b) => a + b),
            total: total_spent,
        },
        willToLives: {
            amount: 0,
            percentage: 0,
            percentile: 0,
        },
    }

    // const beerOrders = orders.filter(x => x.product.is_alcoholic);
    // stats.calories.actualBeers = beerOrders.length <= 0 ? 0 : beerOrders.map(x => x.units).reduce((a, b) => a + b);

    //DaysAtProto
    const days: {
        [key: string]: number
    } = {}
    for (const order of orders) {
        const date = order.created_at.substring(0, 10)
        if (!(date in days)) days[date] = 0
        days[date] += order.units
        stats.days.items += order.units
    }
    stats.days.amount = Object.keys(days).length

    //Drinks
    const drinks: {
        [key: string]: number
    } = {}
    for (const order of orders) {
        if (order.product.name.startsWith('TIPcie')) {
            const date = order.created_at.substring(0, 10)
            if (!(date in drinks)) drinks[date] = 0
            drinks[date] += order.units
            if (order.product.is_alcoholic) {
                stats.drinks.alcoholic += order.units
            } else {
                stats.drinks.nonAlcoholic += order.units
            }
        }
    }

    stats.drinks.amount = Object.keys(drinks).length

    stats.omnomcomdays = new Set(orders.map((x) => x.created_at.slice(5, 10)))

    //MostBought
    const filteredOrders = orders.filter(
        (x) =>
            ![
                825, 826, 827, 831, 841, 855, 881, 883, 975, 979, 980, 986, 998,
                1181, 1184, 1185, 1197, 1198, 1199, 1200, 1201, 1358,
            ].includes(x.product_id)
    )

    const totals: {
        [key: string]: [ProductData, number]
    } = {}
    for (const order of filteredOrders) {
        if (order.product.name in totals)
            totals[order.product.name][1] += order.units
        else totals[order.product.name] = [order.product, order.units]
    }
    stats.mostBought.items = Object.values(totals).sort((a, b) => b[1] - a[1])
    const otherOrders = order_totals[stats.mostBought.items[0][0].id]
    if (stats.mostBought.items[0][1] === otherOrders[otherOrders.length - 1]) {
        stats.mostBought.percentile = 0
    } else {
        let percentileCount = 0
        for (const order of otherOrders) {
            if (stats.mostBought.items[0][1] <= order) {
                break
            }
            percentileCount++
        }
        stats.mostBought.percentile = Math.round(
            ((otherOrders.length - percentileCount) / otherOrders.length) * 100
        )
    }

    //WillToLive
    const willToLives = orders
        .filter((x) => x.product.id === 987)
        .map((el) => el.units)
    stats.willToLives.amount =
        willToLives.length > 0 ? willToLives.reduce((a, b) => a + b) : 0

    const otherWills = order_totals['987']
    stats.willToLives.percentage =
        Math.log(stats.willToLives.amount) /
        Math.log(otherWills[otherWills.length - 1])
    let percentileCountWills = 0
    for (const order of otherWills) {
        if (stats.willToLives.amount <= order) {
            break
        }
        percentileCountWills++
    }
    stats.willToLives.percentile = Math.round(
        ((otherWills.length - percentileCountWills) / otherWills.length) * 100
    )
    // await preloadImages(stats)
    return stats
}

const preloadImages = async (stats: statsType) => {
    await preloadImage(cookieMonster)
    await preloadImage(beugel)
    await preloadImage(lemonade)
    await preloadImage(spilledBeer)
    await preloadImage(tosti)
    await preloadImage(unicorn)
    await preloadImage(unicornBw)
    //Activities
    for (const activity of stats.activities.all) {
        if (activity.image_url) {
            const src = activity.image_url
            let fetched = true
            const blob = await fetch(src)
                .then((response) => response.blob())
                .catch(() => {
                    fetched = false
                })
            if (fetched && blob) {
                activity.image_url = await new Promise((resolve) => {
                    const reader = new FileReader()
                    reader.onload = function () {
                        resolve(reader.result)
                    }
                    reader.readAsDataURL(blob)
                })

                await preloadImage(src)
            }
        }
    }
    //MostBought
    for (const product of stats.mostBought.items.slice(0, 5)) {
        if (product[0].image_url) {
            let fetched = true
            const blob = await fetch(product[0].image_url)
                .then((response) => response.blob())
                .catch(() => {
                    fetched = false
                })

            if (fetched && blob) {
                product[0].image_url = await new Promise((resolve) => {
                    const reader = new FileReader()
                    reader.onload = function () {
                        resolve(reader.result)
                    }
                    reader.readAsDataURL(blob)
                })

                await preloadImage(product[0].image_url)
            }
        }
    }
}

const images = []
const preloadImage = (src: string) =>
    new Promise((resolve, reject) => {
        const img = new Image()
        img.onload = resolve
        img.onerror = reject
        img.src = src
        images.push(img)
    })
