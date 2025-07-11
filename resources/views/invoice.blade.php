"use client"

import { useState, useEffect } from "react"
import { useParams, useRouter } from "next/navigation"
import Image from "next/image"
import { Card, CardContent, CardHeader } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Alert, AlertDescription } from "@/components/ui/alert"
import { Separator } from "@/components/ui/separator"
import { Calendar, Clock, CreditCard, CheckCircle, AlertCircle, Loader2, MapPin, Package } from "lucide-react"

// Mock data - replace with your actual API calls
const mockOrder = {
  id: 1,
  order_code: "ORD-2024-001",
  payment_status: "pending", // pending, paid, failed
  paket: {
    nama_paket: "Premium Health Check",
    gambar: "/placeholder.svg?height=230&width=400",
    rumahSakit: {
      nama: "Jakarta Medical Center",
    },
  },
  booking_date: "2024-01-15",
  booking_time: "08:00 WIB",
  total_price: 5000000,
  paid_at: null,
  payment_method: null,
  snap_token: null,
}

interface Order {
  id: number
  order_code: string
  payment_status: "pending" | "paid" | "failed"
  paket: {
    nama_paket: string
    gambar: string
    rumahSakit: {
      nama: string
    }
  }
  booking_date: string
  booking_time: string
  total_price: number
  paid_at: string | null
  payment_method: string | null
  snap_token: string | null
}

// Declare Midtrans Snap
declare global {
  interface Window {
    snap: {
      pay: (token: string, options: any) => void
    }
  }
}

export default function InvoicePage() {
  const params = useParams()
  const router = useRouter()
  const [order, setOrder] = useState<Order | null>(null)
  const [loading, setLoading] = useState(true)
  const [paying, setPaying] = useState(false)
  const [error, setError] = useState<string | null>(null)

  // Load Midtrans Snap script
  useEffect(() => {
    const script = document.createElement("script")
    script.src = "https://app.sandbox.midtrans.com/snap/snap.js"
    script.setAttribute("data-client-key", process.env.NEXT_PUBLIC_MIDTRANS_CLIENT_KEY || "your-client-key")
    document.head.appendChild(script)

    return () => {
      document.head.removeChild(script)
    }
  }, [])

  // Fetch order data
  useEffect(() => {
    const fetchOrder = async () => {
      try {
        setLoading(true)
        // Replace with your actual API call
        // const response = await fetch(`/api/orders/${params.id}`)
        // const data = await response.json()

        // Simulate API call
        await new Promise((resolve) => setTimeout(resolve, 1000))
        setOrder(mockOrder)
      } catch (err) {
        setError("Failed to load order data")
      } finally {
        setLoading(false)
      }
    }

    if (params.id) {
      fetchOrder()
    }
  }, [params.id])

  // Handle payment
  const handlePayment = async () => {
    if (!order || paying) return

    try {
      setPaying(true)
      setError(null)

      // Get payment token from your backend
      const response = await fetch(`/api/orders/${order.id}/pay`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })

      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.error || "Payment failed")
      }

      // Open Midtrans payment popup
      if (window.snap) {
        window.snap.pay(data.snap_token, {
          onSuccess: async (result: any) => {
            console.log("Payment success:", result)

            // Update order status immediately for better UX
            setOrder((prev) =>
              prev
                ? {
                    ...prev,
                    payment_status: "paid",
                    paid_at: new Date().toISOString(),
                    payment_method: result.payment_type,
                  }
                : null,
            )

            // Verify payment status with backend
            await verifyPaymentStatus(order.id)

            showSuccessAlert()
          },
          onPending: (result: any) => {
            console.log("Payment pending:", result)
            showPendingAlert()
          },
          onError: (result: any) => {
            console.log("Payment error:", result)
            setError("Payment failed. Please try again.")
          },
          onClose: () => {
            console.log("Payment popup closed")
          },
        })
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : "Payment failed")
    } finally {
      setPaying(false)
    }
  }

  // Verify payment status with backend
  const verifyPaymentStatus = async (orderId: number) => {
    try {
      const response = await fetch(`/api/orders/${orderId}/verify`, {
        method: "POST",
      })
      const data = await response.json()

      if (data.payment_status === "paid") {
        setOrder((prev) => (prev ? { ...prev, ...data } : null))
      }
    } catch (err) {
      console.error("Failed to verify payment status:", err)
    }
  }

  const showSuccessAlert = () => {
    // You can replace this with a proper toast/modal system
    alert("Payment successful! Thank you for your payment.")
  }

  const showPendingAlert = () => {
    alert("Payment is pending. Please complete your payment.")
  }

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString("id-ID", {
      day: "numeric",
      month: "long",
      year: "numeric",
    })
  }

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount)
  }

  const getStatusBadge = (status: string) => {
    switch (status) {
      case "paid":
        return <Badge className="bg-green-100 text-green-800 hover:bg-green-200">LUNAS</Badge>
      case "pending":
        return <Badge className="bg-yellow-100 text-yellow-800 hover:bg-yellow-200">MENUNGGU PEMBAYARAN</Badge>
      default:
        return <Badge className="bg-red-100 text-red-800 hover:bg-red-200">BELUM BAYAR</Badge>
    }
  }

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <Loader2 className="w-8 h-8 animate-spin mx-auto mb-4" />
          <p className="text-gray-600">Loading invoice...</p>
        </div>
      </div>
    )
  }

  if (!order) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <Card className="w-full max-w-md">
          <CardContent className="p-6 text-center">
            <AlertCircle className="w-12 h-12 text-red-500 mx-auto mb-4" />
            <h3 className="text-lg font-semibold mb-2">Order Not Found</h3>
            <p className="text-gray-600 mb-4">The requested invoice could not be found.</p>
            <Button onClick={() => router.push("/")} variant="outline">
              Back to Home
            </Button>
          </CardContent>
        </Card>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="container mx-auto px-4 max-w-4xl">
        <Card className="shadow-lg">
          <CardHeader className="bg-blue-600 text-white">
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
              <h1 className="text-xl font-bold">Invoice: {order.order_code}</h1>
              <div className="flex items-center gap-2">
                <span className="text-sm">Status:</span>
                {getStatusBadge(order.payment_status)}
              </div>
            </div>
          </CardHeader>

          <CardContent className="p-6">
            {error && (
              <Alert className="mb-6 border-red-200 bg-red-50">
                <AlertCircle className="h-4 w-4 text-red-600" />
                <AlertDescription className="text-red-800">{error}</AlertDescription>
              </Alert>
            )}

            <div className="grid lg:grid-cols-2 gap-8">
              {/* Order Details */}
              <div>
                <h2 className="text-lg font-semibold mb-4 flex items-center gap-2">
                  <Package className="w-5 h-5" />
                  Detail Pesanan
                </h2>

                <div className="space-y-4">
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-600">Nama Paket</span>
                    <span className="font-medium">{order.paket.nama_paket}</span>
                  </div>

                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-600 flex items-center gap-1">
                      <MapPin className="w-4 h-4" />
                      Rumah Sakit
                    </span>
                    <span className="font-medium">{order.paket.rumahSakit.nama}</span>
                  </div>

                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-600 flex items-center gap-1">
                      <Calendar className="w-4 h-4" />
                      Tanggal Booking
                    </span>
                    <span className="font-medium">{formatDate(order.booking_date)}</span>
                  </div>

                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-600 flex items-center gap-1">
                      <Clock className="w-4 h-4" />
                      Jam Booking
                    </span>
                    <span className="font-medium">{order.booking_time}</span>
                  </div>

                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="text-gray-600">Harga</span>
                    <span className="font-bold text-green-600 text-lg">{formatCurrency(order.total_price)}</span>
                  </div>

                  {order.paid_at && (
                    <div className="flex justify-between py-2 border-b border-gray-100">
                      <span className="text-gray-600">Dibayar Pada</span>
                      <span className="font-medium">
                        {new Date(order.paid_at).toLocaleDateString("id-ID", {
                          day: "numeric",
                          month: "long",
                          year: "numeric",
                          hour: "2-digit",
                          minute: "2-digit",
                        })}
                      </span>
                    </div>
                  )}

                  {order.payment_method && (
                    <div className="flex justify-between py-2 border-b border-gray-100">
                      <span className="text-gray-600 flex items-center gap-1">
                        <CreditCard className="w-4 h-4" />
                        Metode Pembayaran
                      </span>
                      <span className="font-medium capitalize">{order.payment_method}</span>
                    </div>
                  )}
                </div>
              </div>

              {/* Package Image */}
              <div className="text-center">
                <div className="relative w-full h-64 rounded-lg overflow-hidden shadow-md">
                  <Image
                    src={order.paket.gambar || "/placeholder.svg?height=230&width=400"}
                    alt="Package Image"
                    fill
                    className="object-cover"
                  />
                </div>
              </div>
            </div>

            <Separator className="my-8" />

            {/* Payment Section */}
            {order.payment_status !== "paid" ? (
              <div className="text-center space-y-4">
                <p className="text-gray-600">Klik tombol di bawah untuk melanjutkan ke pembayaran.</p>
                <Button
                  onClick={handlePayment}
                  disabled={paying}
                  size="lg"
                  className="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-8 py-3"
                >
                  {paying ? (
                    <>
                      <Loader2 className="w-4 h-4 mr-2 animate-spin" />
                      Memproses...
                    </>
                  ) : (
                    <>
                      <CreditCard className="w-4 h-4 mr-2" />
                      Bayar Sekarang
                    </>
                  )}
                </Button>
              </div>
            ) : (
              <Alert className="bg-green-50 border-green-200">
                <CheckCircle className="h-4 w-4 text-green-600" />
                <AlertDescription className="text-green-800">
                  <div className="text-center">
                    <p className="font-semibold">✅ Pesanan ini sudah dibayar</p>
                    {order.payment_method && (
                      <p className="text-sm mt-1">
                        Metode: {order.payment_method.charAt(0).toUpperCase() + order.payment_method.slice(1)}
                      </p>
                    )}
                  </div>
                </AlertDescription>
              </Alert>
            )}
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
