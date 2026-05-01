import React from 'react';
import { useForm, Head } from '@inertiajs/react';

export default function Create() {
    // O useForm do Inertia gere o estado, erros e CSRF automaticamente
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        status: 'planeamento',
        // Campo Honeypot: invisível para o user, isca para o bot
        address_secondary: '', 
    });

    const submit = (e) => {
        e.preventDefault();
        post('/projects'); // O CSRF é injetado nos headers aqui
    };

    return (
        <div className="max-w-2xl mx-auto p-8 bg-white shadow mt-10 rounded">
            <Head title="Criar Novo Projeto" />
            <h1 className="text-xl font-bold mb-6">Novo Projeto</h1>

            <form onSubmit={submit}>
                {/* Honeypot Field - Escondido de humanos */}
                <div style={{ display: 'none' }} aria-hidden="true">
                    <input 
                        type="text" 
                        name="address_secondary" 
                        value={data.address_secondary}
                        onChange={e => setData('address_secondary', e.target.value)}
                        tabIndex="-1"
                        autoComplete="off"
                    />
                </div>

                <div className="mb-4">
                    <label className="block mb-1">Nome do Projeto</label>
                    <input 
                        type="text" 
                        className="w-full border p-2 rounded"
                        value={data.name}
                        onChange={e => setData('name', e.target.value)}
                    />
                    {errors.name && <div className="text-red-500 text-sm">{errors.name}</div>}
                </div>

                <div className="mb-4">
                    <label className="block mb-1">Descrição</label>
                    <textarea 
                        className="w-full border p-2 rounded"
                        value={data.description}
                        onChange={e => setData('description', e.target.value)}
                    />
                </div>

                <button 
                    type="submit" 
                    disabled={processing}
                    className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                >
                    {processing ? 'A criar...' : 'Guardar Projeto'}
                </button>
            </form>
        </div>
    );
}