import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

import { Contact } from './contact';

@Injectable({
  providedIn: 'root'
})
export class contactservice {

  private apiURL = "http://localhost:8888";

  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  }

  constructor(private httpClient: HttpClient) { }

  getAll(): Observable<Contact[]> {
    return this.httpClient.get<Contact[]>(this.apiURL + '/contacts/')
      .pipe(
        catchError(this.errorHandler)
      )
  }

  create(contact: any): Observable<Contact> {
    return this.httpClient.post<Contact>(this.apiURL + '/contacts/', JSON.stringify(contact), this.httpOptions)
      .pipe(
        catchError(this.errorHandler)
      )
  }

  find(id: number): Observable<Contact> {
    return this.httpClient.get<Contact>(this.apiURL + '/contacts/' + id)
      .pipe(
        catchError(this.errorHandler)
      )
  }

  update(id: number, contact: any): Observable<Contact> {
    return this.httpClient.put<Contact>(this.apiURL + '/contacts/' + id, JSON.stringify(contact), this.httpOptions)
      .pipe(
        catchError(this.errorHandler)
      )
  }

  delete(id: number) {
    return this.httpClient.delete<Contact>(this.apiURL + '/contacts/' + id, this.httpOptions)
      .pipe(
        catchError(this.errorHandler)
      )
  }


  errorHandler(error: { error: { message: string; }; status: any; message: any; }) {
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      errorMessage = error.error.message;
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    return throwError(errorMessage);
  }
}