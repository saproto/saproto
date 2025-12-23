import cookieMonster from '@/../assets/images/wrapped/cookiemonster.png'
import beugel from '@/../assets/images/wrapped/beugel.webp'
import lemonade from '@/../assets/images/wrapped/lemonade.png'
import spilledBeer from '@/../assets/images/wrapped/spilledbeer.png'
import tosti from '@/../assets/images/wrapped/tosti.png'
import unicorn from '@/../assets/images/wrapped/unicorn.png'
import unicornBw from '@/../assets/images/wrapped/unicorn_bw.png'
import colaKoenkert from '@/../assets/images/wrapped/koenkerts/colaKoenkert.png'
import Koenkertsleepingbag from '@/../assets/images/wrapped/koenkerts/Koenkertsleepingbag.png'
import BavarianKoenkert from '@/../assets/images/wrapped/koenkerts/BavarianKoenkert.png'
import KermitKoenkert from '@/../assets/images/wrapped/koenkerts/KermitKoenkert.png'
import Koenkerthighschool from '@/../assets/images/wrapped/koenkerts/Koenkerthighschool.png'
import ProTubeLogo from '@/../assets/images/wrapped/ProTubeLogo.png'

import OrderlineData = App.Data.OrderlineData
import ProductData = App.Data.ProductData
import { statsType } from '@/pages/Wrapped/types'
export const prepareStats = async (
    orders: Array<OrderlineData>,
    order_totals: number[][],
    total_spent: number,
    events: Array<{ price: number }>,
    protube_totals: number[],
    played_videos: Array<App.Data.PlayedVideoData>
) => {
    const caloriesTotal = orders
        .map((x) => x.units * x.product.calories)
        .reduce((a, b) => a + b)
    const stats: statsType = {
        images: {
            cookieMonster: cookieMonster,
            beugel: beugel,
            lemonade: lemonade,
            spilledBeer: spilledBeer,
            tosti: tosti,
            unicorn: unicorn,
            unicornBw: unicornBw,
            proTubeLogo: ProTubeLogo,
        },
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
        koenkert: {
            type: '',
            imageName: ``,
        },
        protube: {
            total: {
                total_played: protube_totals.reduce(
                    (accumulator, video) => accumulator + video,
                    0
                ),
            },
            user: {
                percentile: 0,
                total_played: played_videos.reduce(
                    (accumulator, video) => accumulator + video.played_count,
                    0
                ),
                videos: played_videos.slice(0, 5),
                duration_played: '0 minutes',
            },
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

    const secondsPlayed = played_videos.reduce(
        (accumulator, video) =>
            accumulator +
            (video.sum_duration_played ?? 238.15 * video.played_count),
        0
    )
    const minutesPlayed = secondsPlayed / 60
    const hoursPlayed = minutesPlayed / 60
    const daysPlayed = hoursPlayed / 24
    if (daysPlayed > 1) {
        stats.protube.user.duration_played = `${daysPlayed.toFixed(2)} days`
    } else if (hoursPlayed > 0) {
        stats.protube.user.duration_played = `${hoursPlayed.toFixed(2)} hours`
    } else if (minutesPlayed > 0) {
        stats.protube.user.duration_played = `${minutesPlayed.toFixed(2)} minutes`
    } else if (secondsPlayed > 0) {
        stats.protube.user.duration_played = `${secondsPlayed.toFixed(2)} seconds`
    } else {
        stats.protube.user.duration_played = `you not having used ProTube at all!`
    }

    let percentileCountProtube = 0
    for (const amount of protube_totals) {
        if (stats.protube.user.total_played <= amount) {
            break
        }
        percentileCountProtube++
    }
    stats.protube.user.percentile = Math.max(
        1,
        Math.round(
            ((protube_totals.length - percentileCountProtube) /
                protube_totals.length) *
                100
        )
    )

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
    //category Koenkert
    const amountForOptions: {
        [key: string]: { products: number[]; amount: number; imageName: string }
    } = {
        'Big Corporate cookie monster': {
            products: [35],
            amount: 0,
            imageName: colaKoenkert,
        },
        'Bavarian cookie monster': {
            products: [
                24, 211, 376, 494, 757, 758, 759, 761, 805, 810, 957, 1005,
                1039, 1173, 1247, 1618, 1619, 1621, 1667, 1668, 1669,
            ],
            amount: 0,
            imageName: BavarianKoenkert,
        },
        '2 cookie monsters in a golden sleeping bag': {
            products: [27],
            amount: 0,
            imageName: Koenkertsleepingbag,
        },
        'Kermit the cookie monster': {
            products: [954],
            amount: 0,
            imageName: KermitKoenkert,
        },
        'High school cookie monster': {
            products: [1504, 1688],
            amount: 0,
            imageName: Koenkerthighschool,
        },
    }
    for (const order of orders) {
        for (const option in amountForOptions) {
            if (amountForOptions[option].products.includes(order.product_id)) {
                amountForOptions[option].amount += order.units
            }
        }
    }
    let maxCategory = ''
    let maxAmount = 0
    for (const option in amountForOptions) {
        if (amountForOptions[option].amount > maxAmount) {
            maxAmount = amountForOptions[option].amount
            maxCategory = option
        }
    }
    stats.koenkert.type = maxCategory
    stats.koenkert.imageName = amountForOptions[maxCategory].imageName
    await preloadImages(stats)
    return stats
}

const preloadImages = async (stats: statsType) => {
    stats.images.cookieMonster = await fetchImageAsBase64(
        stats.images.cookieMonster
    )
    stats.images.beugel = await fetchImageAsBase64(stats.images.beugel)
    stats.images.lemonade = await fetchImageAsBase64(stats.images.lemonade)
    stats.images.spilledBeer = await fetchImageAsBase64(
        stats.images.spilledBeer
    )
    stats.images.tosti = await fetchImageAsBase64(stats.images.tosti)
    stats.images.unicorn = await fetchImageAsBase64(stats.images.unicorn)
    stats.images.unicornBw = await fetchImageAsBase64(stats.images.unicornBw)
    stats.images.proTubeLogo = await fetchImageAsBase64(
        stats.images.proTubeLogo
    )
    //Activities
    for (const activity of stats.activities.all) {
        activity.image_url = await fetchImageAsBase64(activity.image_url)
    }
    stats.koenkert.imageName = await fetchImageAsBase64(
        stats.koenkert.imageName
    )
    //MostBought
    for (const product of stats.mostBought.items.slice(0, 5)) {
        product[0].image_url = await fetchImageAsBase64(product[0].image_url)
    }
}

export const blobToBase64 = (blob: Blob): Promise<string> => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onload = () => {
            resolve(reader.result as string)
        }

        reader.onerror = (error) => {
            reject(error)
        }
        reader.readAsDataURL(blob)
    })
}

const fetchImageAsBase64 = async (url: string): Promise<string> => {
    if (!url) {
        return url
    }
    try {
        const response = await fetch(url)
        if (!response.ok) {
            console.warn(`Failed to fetch image (${response.status}): ${url}`)
            return url
        }

        const blob = await response.blob()
        return await blobToBase64(blob)
    } catch (error) {
        console.warn(`Error fetching image: ${url}`, error)
        return url
    }
}
