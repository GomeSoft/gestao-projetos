import React from 'react';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ projects }) {
    return (
        <div className="py-12 bg-gray-100 min-h-screen">
            <Head title="Dashboard de Projetos" />

            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 className="text-2xl font-bold mb-6">Os Meus Projetos</h1>

                    {/* Proteção XSS: O React escapa automaticamente estas variáveis */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {projects.map((project) => (
                            <div key={project.id} className="border p-4 rounded-lg hover:bg-gray-50">
                                <h2 className="font-semibold text-lg">{project.name}</h2>
                                <p className="text-gray-600 text-sm mb-4">
                                    Status: <span className="capitalize">{project.status}</span>
                                </p>
                                
                                {/* Link Seguro: O IDOR é validado no Backend se o user tentar mudar o ID no URL */}
                                <Link 
                                    href={`/projects/${project.id}`}
                                    className="text-blue-500 hover:underline font-medium"
                                >
                                    Ver Detalhes →
                                </Link>
                            </div>
                        ))}
                    </div>

                    {projects.length === 0 && (
                        <p className="text-gray-500 text-center">Nenhum projeto encontrado.</p>
                    )}
                </div>
            </div>
        </div>
    );
}