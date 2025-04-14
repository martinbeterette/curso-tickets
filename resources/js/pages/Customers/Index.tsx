import { Button } from '@/components/ui/button';
import { DataTable } from '@/components/ui/data-table';
import AppLayout from '@/layouts/app-layout';
import { Customer, PageProps, type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { ColumnDef } from '@tanstack/react-table';
import { Plus, Trash2 } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Customers',
        href: '/customers',
    },
];

export default function Index() {
    const columns: ColumnDef<Customer>[] = [
        {
            accessorKey: 'id',
            header: 'ID',
        },
        {
            accessorKey: 'name',
            header: 'Name',
        },
        {
            accessorKey: 'email',
            header: 'Email',
        },
        {
            accessorKey: 'phone',
            header: 'Phone',
        },
        {
            accessorKey: 'address',
            header: 'Address',
        },
        {
            id: 'actions',
            header: 'Actions',
            cell: ({ row }) => {
                const customer = row.original;
                return (
                    <Button variant="destructive" size="sm" onClick={() => handleDelete(customer.id)}>
                        <Trash2 className="h-4 w-4" />
                    </Button>
                );
            },
        },
    ];

    const { customers } = usePage<PageProps>().props;

    const handleDelete = (id: number) => {
        if (confirm('Are you sure you want to delete this record??')) {
            router.delete(route('customers.destry', id));
        }
    };

    const handlePageChange = (url: string | null) => {
        if (url) {
            router.get(url);
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Customers" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Customers</h1>
                    <Link href={route('customers.create')}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" /> Add Costumer
                        </Button>
                    </Link>
                </div>

                <DataTable
                    columns={columns}
                    data={customers.data}
                    pagination={{
                        from: customers.from,
                        to: customers.to,
                        total: customers.total,
                        links: customers.links,
                        onPageChange: handlePageChange,
                    }}
                />
            </div>
        </AppLayout>
    );
}
