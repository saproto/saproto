declare namespace App.Models {
    type PasswordReset = {
        email: string;
        token: string;
        valid_to: number;
    }
}
