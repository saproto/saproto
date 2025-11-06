import ProductData = App.Data.ProductData

export interface statsType {
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
    december: {
        complete: boolean
        items: number
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
}
