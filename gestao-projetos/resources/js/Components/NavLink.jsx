import { Link, useForm } from '@inertiajs/react';

export default function Navigation() {
    const { post } = useForm();

    const handleLogout = (e) => {
        e.preventDefault();
        // Chamada ao endpoint que criámos na Task 103
        post(route('logout'), {
            onFinish: () => {
                // Opcional: Limpar qualquer dado sensível do localStorage
                localStorage.removeItem('user_preferences');
                console.log('Sessão encerrada e tokens revogados.');
            },
        });
    };

    return (
        <nav>
            {/* Outros links... */}
            <button
                onClick={handleLogout}
                className="text-red-600 hover:text-red-800 font-medium"
            >
                Encerrar Sessão
            </button>
        </nav>
    );
}