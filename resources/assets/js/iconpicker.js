// Enable FontAwesome icon pickers
import Iconpicker from 'codethereal-iconpicker'
import './utilities'
const iconPickerList = Array.from(
    document.getElementsByClassName('iconpicker-wrapper')
)
window.iconPickers = {}
if (iconPickerList.length) {
    // Get available icons from fontawesome GraphQL api
    post('https://api.fontawesome.com/', {
        query: `{
              release(version: "latest") {
                version
                icons {
                  id
                  membership { free }
                }
              }
            }`,
    })
        .then((data) => {
            const icons = data.data.release.icons.reduce((collection, icon) => {
                const styles = icon.membership.free
                for (const key in styles) {
                    collection.push(`fa${styles[key].charAt(0)} fa-${icon.id}`)
                }
                return collection
            }, [])
            iconPickerList.forEach((el) => {
                const iconpicker = el.querySelector('.iconpicker')
                window.iconPickers[el.id] = new Iconpicker(iconpicker, {
                    icons: icons,
                    defaultValue: iconpicker.value,
                    showSelectedIn: el.querySelector('.selected-icon'),
                })
            })
            console.log(
                `Icon-picker initialized (FontAwesome v${data.data.release.version}, ${icons.length} icons)`
            )
        })
        .catch((err) => {
            console.log('Error retrieving icons for icon pickers: ', err)
        })
}
