import ProductData = App.Data.ProductData

export interface statsType {
    images: {
        cookieMonster: string
        beugel: string
        lemonade: string
        spilledBeer: string
        tosti: string
        unicorn: string
        unicornBw: string
        proTubeLogo: string
    }
    activities: {
        amount: number
        spent: string | number
        all: any
    }
    calories: {
        amount: number
        tostis: number
    }
    days: {
        amount: number
        items: number
    }
    drinks: {
        alcoholic: number
        nonAlcoholic: number
        amount: number
    }
    omnomcomdays: Set<string>
    mostBought: {
        items: [ProductData, number][]
        percentile: number
    }
    totalSpent: {
        amount: number
        total: number
    }
    willToLives: {
        amount: number
        percentage: number
        percentile: number
    }
    koenkert: {
        type: string
        imageName: string
    }
    protube: {
        user: {
            duration_played: string
            percentile: number
            total_played: number
            videos: Array<App.Data.PlayedVideoData>
        }
        total: {
            total_played: number
        }
    }
}
